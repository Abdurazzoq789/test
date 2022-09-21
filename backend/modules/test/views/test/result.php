<?php
/**
 * @var $model \common\models\Test
 */

use common\models\Answer;

$correctCount = $model->getTestResult();
?>

<h1><?= $model->title ?> Result</h1>
<div class="row">
    <div class="col-sm-3">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Question Count</h5>
                <p class="card-text"><?= $model->count ?></p>
                <a href="<?= \yii\helpers\Url::to(['/test/test/answer', 'test_id' => $model->id]) ?>" class="btn btn-primary">All results</a>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Count of correct</h5>
                <p class="card-text"><?= $correctCount ?></p>
                <a href="<?= \yii\helpers\Url::to(['/test/test/answer', 'correct' => Answer::ANSWER_CORRECT, 'test_id' => $model->id]) ?>" class="btn btn-primary">Correct Answers</a>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Count of incorrec</h5>
                <p class="card-text"><?= $model->count - $correctCount ?></p>
                <a href="<?= \yii\helpers\Url::to(['/test/test/answer', 'correct' => Answer::ANSWER_INCORRECT, 'test_id' => $model->id]) ?>" class="btn btn-primary">Incorrect Answers</a>
            </div>
        </div>
    </div>
</div>