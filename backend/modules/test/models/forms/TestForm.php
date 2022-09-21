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

    public function rules()
    {
        return [
            [['id', 'count', 'level_id', 'user_id'], 'integer'],
            [['title', 'count', 'level_id', 'user_id'], 'required'],
            [['tagNames', 'started_at'], 'safe'],
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->started_at = strtotime($this->started_at);
        $levelQuestionCount = Question::find()->andWhere(['level_id' => $this->level_id])->count();
        if ($this->count > $levelQuestionCount) {
            $this->addError('count', "Not enough question");
            return false;
        }
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

        $questions = Question::find()
            ->andWhere(['level_id' => $this->level_id])
            ->orderBy('rand()')
            ->limit($this->count)->all();
        foreach ($questions as $index => $question) {
            $testQuestion = new TestQuestion([
                'test_id' => $model->id,
                'question_id' => $question->id
            ]);

            $testQuestion->save();
        }

        return $model;
    }


}