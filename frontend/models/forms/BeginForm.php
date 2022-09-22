<?php

namespace frontend\models\forms;

use common\models\Test;
use common\models\TestQuestion;
use common\models\TestQuestionAnswer;
use yii\db\Query;

class BeginForm extends \yii\base\Model
{
    public Test $test;

    public $testQuestion;

    public bool $done = false;

    public $answer_id;


    public function __construct(Test $test, $config = [])
    {
        parent::__construct($config);
        $this->test = $test;

        if (!$test->started_at){
            $test->updateAttributes(['started_at' => time()]);
        }

        $subQuery = (new Query())->select('test_question_id')
            ->from('test_question_answer');

        $this->testQuestion = TestQuestion::find()
            ->andWhere(['test_id' => $this->test->id])
            ->andWhere(['not in', 'id', $subQuery])
            ->orderBy(['status' => SORT_ASC])
            ->one();


        if ($this->testQuestion == null ||
            $this->test->status == Test::STATUS_COMPETED ||
            time() > ($this->test->started_at + ($this->test->deadline * 60)))
        {
            $this->test->updateAttributes(['status' => Test::STATUS_COMPETED]);
            $this->done = true;
        }
    }

    public function rules()
    {
        return [
          [['answer_id'], 'integer']
        ];
    }

    public function save()
    {
        if (!$this->validate()){
            return false;
        }

        $testQuestionAnswer = new TestQuestionAnswer([
            'test_question_id' => $this->testQuestion->id
        ]);

        $testQuestionAnswer->setAttributes($this->attributes);
        if (!$testQuestionAnswer->save()){
            $this->addErrors($testQuestionAnswer->errors);
            return false;
        }

        return true;
    }

}