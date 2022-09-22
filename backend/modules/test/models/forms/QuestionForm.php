<?php

namespace backend\modules\test\models\forms;

use common\models\Answer;
use common\models\Question;
use dosamigos\taggable\Taggable;
use yii\base\Model;
use yii\db\Query;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;

class QuestionForm extends Model
{
    public $tagNames;

    public $text;

    public $score;

    public $level_id;

    public $status;

    public $id;

    public $answers;

    public Question $question;

    public function __construct(Question $question,$config = [])
    {
        parent::__construct($config);

        $this->score = $question->score;
        $this->text = $question->text;
        $this->level_id = $question->level_id;
        $this->status = $question->status;
        $this->answers = $question->answers;
        $this->tagNames = (new Query())->select(['group_concat(name separator ",") as name'])
            ->from("tag")
            ->leftJoin("question_tag", "question_tag.tag_id = tag.id")
            ->andWhere(['question_tag.question_id' => $question->id])
            ->one()['name'];

        $this->question = $question;
    }


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

        $model = $this->question;

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