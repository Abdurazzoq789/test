<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "test".
 *
 * @property int $id
 * @property string|null $title
 * @property float|null $passing_score
 * @property int|null $started_at
 * @property int|null $status
 * @property int|null $deadline
 * @property int|null $user_id
 *
 * @property Tag[] $tags
 * @property TestQuestion[] $testQuestions
 * @property TestTag[] $testTags
 * @property User $user
 */
class Test extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['passing_score'], 'number'],
            [['started_at', 'status', 'deadline', 'user_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'passing_score' => 'Passing Score',
            'started_at' => 'Started At',
            'status' => 'Status',
            'deadline' => 'Deadline',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[Tags]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\TagQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('test_tag', ['test_id' => 'id']);
    }

    /**
     * Gets query for [[TestQuestions]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\TestQuestionQuery
     */
    public function getTestQuestions()
    {
        return $this->hasMany(TestQuestion::className(), ['test_id' => 'id']);
    }

    /**
     * Gets query for [[TestTags]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\TestTagQuery
     */
    public function getTestTags()
    {
        return $this->hasMany(TestTag::className(), ['test_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\TestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\TestQuery(get_called_class());
    }
}
