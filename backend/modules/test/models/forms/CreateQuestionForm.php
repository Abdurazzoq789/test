<?php

namespace backend\modules\test\models\forms;

use common\models\Answer;
use common\models\Question;
use dosamigos\taggable\Taggable;
use yii\base\Model;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;

class CreateQuestionForm extends Model
{
    public $tagNames;

    public $text;

    public $score;

    public $level_id;

    public $status;

    public $id;

    public $answers;


    public function rules()
    {
        return [
            [['text', 'score', 'level_id'], 'required'],
            [['status', 'id'], 'integer'],
            [['tagNames', 'answers'], 'safe'],
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        $transaction = \Yii::$app->db->beginTransaction();

        if (!$this->id) {
            $model = new Question();
        } else {
            $model = Question::findOne($this->id);
        }

        $model->setAttributes($this->attributes);

        if (!$model->save()) {
            $transaction->rollBack();
            $this->addErrors($model->errors);
            return false;
        }

        if (count($this->answers)) {
            $counter = 1;
            Answer::deleteAll(['question_id' => $model->id]);
            foreach ($this->answers as $index => $answer) {
                $answerModel = new Answer();
                $answerModel->setAttributes($answer);
                $answerModel->sort = $counter;
                $answerModel->question_id = $model->id;
                if (!$answerModel->save()) {
                    $transaction->rollBack();
                    $this->addErrors($answerModel->errors);
                    return false;
                }
                $counter++;
            }
        }

        $transaction->commit();
        return $model;
    }


}