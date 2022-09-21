<?php

namespace common\models;

use dosamigos\taggable\Taggable;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Query;

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
 * @property int|null $count
 *
 * @property Tag[] $tags
 * @property TestQuestion[] $testQuestions
 * @property TestTag[] $testTags
 * @property User $user
 */
class Test extends \yii\db\ActiveRecord
{
    public $level_id;

    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = -1;

    const STATUS_COMPETED = 6;
    public $tagNames;


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
            [['status', 'deadline', 'user_id', 'count'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['level', 'started_at', 'tagNames'], 'safe']
        ];
    }


    public function behaviors()
    {
        return [
            'tag' => [
                'class' => Taggable::className(),
            ]
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
            'count' => 'Question Count'
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

    public function getQuestionCount()
    {
        return $this->getTestQuestions()->count();
    }

    public function getTestResult($correct = Answer::ANSWER_CORRECT)
    {
        $query = (new Query())->from('test_question_answer')
            ->leftJoin("test_question tq", "tq.id = test_question_answer.test_question_id")
            ->leftJoin("answer a", "a.id = test_question_answer.answer_id")
            ->andWhere(['tq.test_id' => $this->id]);

        if ($correct == Answer::ANSWER_CORRECT) {
            $query->andWhere(['a.correct' => Answer::ANSWER_CORRECT]);
        } elseif ($correct == Answer::ANSWER_INCORRECT) {
            $query->andWhere(['a.correct' => Answer::ANSWER_INCORRECT]);
        }
        return $query->count();
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

    public static function getStatus()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive'
        ];
    }
}
