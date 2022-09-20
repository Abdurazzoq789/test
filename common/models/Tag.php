<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $type
 * @property int|null $status
 * @property int|null $frequency
 *
 * @property QuestionTag[] $questionTags
 * @property Question[] $questions
 * @property TestTag[] $testTags
 * @property Test[] $tests
 */
class Tag extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = -1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'status', 'frequency'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'status' => 'Status',
            'frequency' => 'Frequency',
        ];
    }

    /**
     * Gets query for [[QuestionTags]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\QuestionTagQuery
     */
    public function getQuestionTags()
    {
        return $this->hasMany(QuestionTag::className(), ['tag_id' => 'id']);
    }

    /**
     * Gets query for [[Questions]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\QuestionQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['id' => 'question_id'])->viaTable('question_tag', ['tag_id' => 'id']);
    }

    /**
     * Gets query for [[TestTags]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\TestTagQuery
     */
    public function getTestTags()
    {
        return $this->hasMany(TestTag::className(), ['tag_id' => 'id']);
    }

    /**
     * Gets query for [[Tests]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\TestQuery
     */
    public function getTests()
    {
        return $this->hasMany(Test::className(), ['id' => 'test_id'])->viaTable('test_tag', ['tag_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\TagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\TagQuery(get_called_class());
    }

    public static function getDropdownList()
    {
        return ArrayHelper::map(self::find()->active()->all(), 'id', 'name');
    }

    public static function findAllByName($query)
    {
        return self::find()->andWhere(['like', 'lower(name)', mb_strtolower($query)])->all();
    }
}
