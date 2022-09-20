<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "test_tag".
 *
 * @property int $test_id
 * @property int $tag_id
 *
 * @property Tag $tag
 * @property Test $test
 */
class TestTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['test_id', 'tag_id'], 'required'],
            [['test_id', 'tag_id'], 'integer'],
            [['test_id', 'tag_id'], 'unique', 'targetAttribute' => ['test_id', 'tag_id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag_id' => 'id']],
            [['test_id'], 'exist', 'skipOnError' => true, 'targetClass' => Test::className(), 'targetAttribute' => ['test_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'test_id' => 'Test ID',
            'tag_id' => 'Tag ID',
        ];
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
     * Gets query for [[Test]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\TestQuery
     */
    public function getTest()
    {
        return $this->hasOne(Test::className(), ['id' => 'test_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\TestTagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\TestTagQuery(get_called_class());
    }
}
