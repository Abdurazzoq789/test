<?php

namespace common\models;

use dosamigos\taggable\Taggable;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "question".
 *
 * @property int $id
 * @property string|null $text
 * @property float|null $score
 * @property int|null $level_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Answer[] $answers
 * @property Level $level
 * @property QuestionTag[] $questionTags
 * @property Tag[] $tags
 * @property TestQuestion[] $testQuestions
 */
class Question extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = -1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'question';
    }

    public $tagNames;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['score'], 'number'],
            [['tagNames'], 'safe'],
            [['level_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['level_id'], 'exist', 'skipOnError' => true, 'targetClass' => Level::className(), 'targetAttribute' => ['level_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
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
            'text' => 'Text',
            'score' => 'Score',
            'level_id' => 'Level ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Answers]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\AnswerQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['question_id' => 'id']);
    }

    public function getCorrectAnswerText()
    {
        return $this->getAnswers()->andWhere(['correct' => Answer::ANSWER_CORRECT])
            ->select(["group_concat(text separator ',') as text"])->orderBy('id')->one();
    }

    public function getCorrectAnswer()
    {
        return $this->hasOne(Answer::className(), ['question_id' => 'id'])->andWhere(['correct' => Answer::ANSWER_CORRECT]);
    }

    /**
     * Gets query for [[Level]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\LevelQuery
     */
    public function getLevel()
    {
        return $this->hasOne(Level::className(), ['id' => 'level_id']);
    }

    /**
     * Gets query for [[QuestionTags]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\QuestionTagQuery
     */
    public function getQuestionTags()
    {
        return $this->hasMany(QuestionTag::className(), ['question_id' => 'id']);
    }

    /**
     * Gets query for [[Tags]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\TagQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('question_tag', ['question_id' => 'id']);
    }

    /**
     * Gets query for [[TestQuestions]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\TestQuestionQuery
     */
    public function getTestQuestions()
    {
        return $this->hasMany(TestQuestion::className(), ['question_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\QuestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\QuestionQuery(get_called_class());
    }

    public static function getStatus()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive'
        ];
    }
}
