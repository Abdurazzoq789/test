<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "test_question".
 *
 * @property int $id
 * @property int|null $test_id
 * @property int|null $question_id
 * @property int|null $status
 *
 * @property Answer[] $answers
 * @property Question $question
 * @property Test $test
 * @property TestQuestionAnswer[] $testQuestionAnswers
 * @property TestQuestionAnswer $testQuestionAnswer
 */
class TestQuestion extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;

    const STATUS_SKIP = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test_question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['test_id', 'question_id'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['question_id' => 'id']],
            [['test_id'], 'exist', 'skipOnError' => true, 'targetClass' => Test::className(), 'targetAttribute' => ['test_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'test_id' => 'Test ID',
            'question_id' => 'Question ID',
        ];
    }

    /**
     * Gets query for [[Answers]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\AnswerQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['id' => 'answer_id'])->viaTable('test_question_answer', ['test_question_id' => 'id']);
    }

    public function getAnswersText()
    {
        return $this->getAnswers()->select(["group_concat(text separator ',') as text"])
            ->orderBy('id')->one();
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
     * Gets query for [[Test]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\TestQuery
     */
    public function getTest()
    {
        return $this->hasOne(Test::className(), ['id' => 'test_id']);
    }

    /**
     * Gets query for [[TestQuestionAnswers]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\TestQuestionAnswerQuery
     */
    public function getTestQuestionAnswers()
    {
        return $this->hasMany(TestQuestionAnswer::className(), ['test_question_id' => 'id']);
    }

    public function getTestQuestionAnswer()
    {
        return $this->hasOne(TestQuestionAnswer::className(), ['test_question_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\TestQuestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\TestQuestionQuery(get_called_class());
    }
}
