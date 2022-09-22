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

    public function rules()
    {
        return [
            [['id', 'count', 'user_id', 'deadline', 'level_id'], 'integer'],
            [['title', 'count', 'user_id', 'deadline'], 'required'],
            [['tagNames', 'started_at', 'levelIds', 'tagIds'], 'safe'],
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->deadline = abs($this->deadline);

        $model = new Test();
        if ($this->id) {
            $model = Test::findOne($this->id);
            TestQuestion::deleteAll(['test_id' => $model->id]);
        }

        $model->setAttributes($this->attributes);

        if (!$model->save()) {
            $this->addErrors($model->errors);
            return false;
        }

        $questionsQuery = Question::find()
            ->andFilterWhere(['level_id' => $this->levelIds]);

        if ($this->tagIds){
            $questionsQuery->leftJoin("question_tag", "question_tag.question_id = question.id")
                ->andWhere(['question_tag.tag_id' => $this->tagIds]);
        }

        $questionsQuery->orderBy('rand()')
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