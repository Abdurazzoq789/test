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

    public function __construct(Question $question, $config = [])
    {
        parent::__construct($config);

        $this->score = $question->score;
        $this->text = $question->text;
        $this->level_id = $question->level_id;
        $this->status = $question->status;
        $this->answers = $question->answers;
        $this->tagNames = join(',', $this->tagList($question->id));

        $this->question = $question;
    }


    public function rules()
    {
        return [
            [['text', 'level_id'], 'required'],
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
        try {
            $model = $this->question;

            $this->tagNames = $this->removeDuplicateTags($this->tagNames);
            $model->setAttributes($this->attributes);


            if (!$model->save()) {
                $transaction->rollBack();
                $this->addErrors($model->errors);
                return false;
            }

            if (!$this->saveAnswers($this->answers, $model->id)) {
                $transaction->rollBack();
                return false;
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $model;
    }

    public function saveAnswers($answers, $question_id)
    {
        if (count($answers) <= 0) {
            return true;
        }

        $counter = 1;
        Answer::deleteAll(['question_id' => $question_id]);
        foreach ($answers as $index => $answer) {
            $check = Answer::find()->andWhere(['question_id' => $question_id])->andWhere(['lower(text)' => $answer])->exists();
            if ($check) {
                $this->addError('answers', 'Not available same name in answers');
                return false;
            }
            $answerModel = new Answer();
            $answerModel->setAttributes($answer);
            $answerModel->sort = $counter;
            $answerModel->question_id = $question_id;
            if (!$answerModel->save()) {
                $this->addErrors($answerModel->errors);
                return false;
            }
            $counter++;
        }

        return true;
    }

    public function removeDuplicateTags($tagNames)
    {
        $tagNames = mb_strtolower($tagNames);
        $result = explode(',', $tagNames);

        $result = array_unique($result);

        return implode(',', $result);
    }

    private function tagList($question_id)
    {
        return (new Query())->select(['name'])
            ->from("tag")
            ->innerJoin("question_tag", "question_tag.tag_id = tag.id")
            ->andWhere(['question_tag.question_id' => $question_id])
            ->column();
    }

}