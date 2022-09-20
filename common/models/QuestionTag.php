<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "question_tag".
 *
 * @property int $question_id
 * @property int $tag_id
 *
 * @property Question $question
 * @property Tag $tag
 */
class QuestionTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'question_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question_id', 'tag_id'], 'required'],
            [['question_id', 'tag_id'], 'integer'],
            [['question_id', 'tag_id'], 'unique', 'targetAttribute' => ['question_id', 'tag_id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['question_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'question_id' => 'Question ID',
            'tag_id' => 'Tag ID',
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
     * Gets query for [[Tag]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\TagQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\QuestionTagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\QuestionTagQuery(get_called_class());
    }
}
