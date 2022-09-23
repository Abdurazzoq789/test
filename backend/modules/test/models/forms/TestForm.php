<?php

namespace backend\modules\test\models\forms;

use common\models\Question;
use common\models\Test;
use common\models\TestQuestion;
use Yii;
use yii\db\Query;
use yii\helpers\VarDumper;

class TestForm extends \yii\base\Model
{

    public $title;

    public $count;

    public $started_at;

    public $user_id;

    public $level_id;

    public $tagNames;

    public $id;

    public $tagIds;

    public $deadline;

    public $levelIds;

    public Test $test;

    public function __construct(Test $test, $config = [])
    {
        parent::__construct($config);
        $this->test = $test;

        $this->setAttributes($test->attributes);

        $this->started_at = Yii::$app->formatter->asDatetime($this->started_at, 'php:Y-m-d H:i:s');

        $this->tagNames = (new Query())->select(['group_concat(name separator ",") as name'])
            ->from("tag")
            ->innerJoin("test_tag", "test_tag.tag_id = tag.id")
            ->andWhere(['test_tag.test_id' => $test->id])
            ->one()['name'];
    }

    public function rules()
    {
        return [
            [['id', 'user_id', 'level_id'], 'integer'],
            [['title', 'count', 'deadline'], 'required'],
            [['count'], 'integer', 'min' => 1, 'max' => Question::getAllCount()],
            [['deadline'], 'integer', 'min' => 1],
            [['tagNames', 'started_at', 'levelIds', 'tagIds'], 'safe'],
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->deadline = abs($this->deadline);

        $model = $this->test;

        $model->setAttributes($this->attributes);

        if (!$model->save()) {
            $this->addErrors($model->errors);
            return false;
        }

        if (!$this->test->isNewRecord) {
            TestQuestion::deleteAll(['test_id' => $model->id]);
        }

        $questionsQuery = Question::find()
            ->andFilterWhere(['level_id' => $this->levelIds]);

        if ($this->tagIds){
            $questionsQuery->leftJoin("question_tag", "question_tag.question_id = question.id")
                ->andWhere(['question_tag.tag_id' => $this->tagIds]);
        }

        $questionsQuery->active()->orderBy('rand()')
            ->limit($this->count);

        if ($questionsQuery->count() < $model->count){
            $model->updateAttributes(['count' => $questionsQuery->count()]);
        }

        foreach ($questionsQuery->all() as $index => $question) {
            $testQuestion = new TestQuestion([
                'test_id' => $model->id,
                'question_id' => $question->id
            ]);

            $testQuestion->save();
        }

        return $model;
    }


}