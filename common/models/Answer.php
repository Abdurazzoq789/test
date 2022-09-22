<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "answer".
 *
 * @property int $id
 * @property int|null $question_id
 * @property string|null $text
 * @property int|null $sort
 * @property int|null $correct
 * @property int|null $status
 *
 * @property Question $question
 * @property TestQuestionAnswer[] $testQuestionAnswers
 * @property TestQuestion[] $testQuestions
 */
class Answer extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = -1;

    const ANSWER_CORRECT = 1;

    const ANSWER_INCORRECT = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question_id', 'sort', 'correct', 'status'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['text'], 'string'],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['question_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_id' => 'Question ID',
            'text' => 'Text',
            'sort' => 'Sort',
            'correct' => 'Correct',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Question]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\QuestionQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }

    /**
     * Gets query for [[TestQuestionAnswers]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\TestQuestionAnswerQuery
     */
    public function getTestQuestionAnswers()
    {
        return $this->hasMany(TestQuestionAnswer::className(), ['answer_id' => 'id']);
    }

    /**
     * Gets query for [[TestQuestions]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\TestQuestionQuery
     */
    public function getTestQuestions()
    {
        return $this->hasMany(TestQuestion::className(), ['id' => 'test_question_id'])->viaTable('test_question_answer', ['answer_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\AnswerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\AnswerQuery(get_called_class());
    }

    public static function getAnswerdCount($test_id)
    {
        $query = (new Query())->from('answer')
            ->leftJoin("test_question_answer tqa", "answer.id = tqa.answer_id")
            ->leftJoin("test_question tq", "tq.id = tqa.test_question_id")
            ->andWhere(['tq.test_id' => $test_id]);

        return $query->count();
    }
}
