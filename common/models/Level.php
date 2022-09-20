<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "level".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $status
 *
 * @property Question[] $questions
 */
class Level extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = -1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'level';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
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
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Questions]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\QuestionQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['level_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\LevelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\LevelQuery(get_called_class());
    }

    public static function getStatus()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive'
        ];
    }

    public static function getDropdownList()
    {
        return ArrayHelper::map(self::find()->active()->all(), 'id', 'name');
    }
}
