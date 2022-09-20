<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "test_question_answer".
 *
 * @property int $test_question_id
 * @property int $answer_id
 *
 * @property Answer $answer
 * @property TestQuestion $testQuestion
 */
class TestQuestionAnswer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test_question_answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['test_question_id', 'answer_id'], 'required'],
            [['test_question_id', 'answer_id'], 'integer'],
            [['test_question_id', 'answer_id'], 'unique', 'targetAttribute' => ['test_question_id', 'answer_id']],
            [['answer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Answer::className(), 'targetAttribute' => ['answer_id' => 'id']],
            [['test_question_id'], 'exist', 'skipOnError' => true, 'targetClass' => TestQuestion::className(), 'targetAttribute' => ['test_question_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'test_question_id' => 'Test Question ID',
            'answer_id' => 'Answer ID',
        ];
    }

    /**
     * Gets query for [[Answer]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\AnswerQuery
     */
    public function getAnswer()
    {
        return $this->hasOne(Answer::className(), ['id' => 'answer_id']);
    }

    /**
     * Gets query for [[TestQuestion]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\TestQuestionQuery
     */
    public function getTestQuestion()
    {
        return $this->hasOne(TestQuestion::className(), ['id' => 'test_question_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\TestQuestionAnswerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\TestQuestionAnswerQuery(get_called_class());
    }
}
