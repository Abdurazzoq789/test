<?php
/**
 * @var $model \common\models\Test
 */

use common\models\Answer;

$correctCount = $model->getTestResult();
?>

<h1><?= $model->title ?> Results </h1>
<div class="card">
    <div class="card-body">
        <div class="card-header">
            <p><span style="color: green">Correct answers count</span> : <b><?= $correctCount ?></b>
                || <span style="color: red">Incorrect answers count</span> : <b><?= $model->count - $correctCount ?></b></p>
        </div>
        <div class="row my-row">
            <?php foreach ($model->testQuestions as $testQuestion) : ?>
                <?php
                $userAnswer = $testQuestion->testQuestionAnswer->answer;
                $correctAnswer = $testQuestion->question->correctAnswer;
                $btnClass = ($userAnswer->id == $correctAnswer->id) ? 'btn-success' : 'btn-danger'
                ?>
                <div class="col-12 item-row">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $testQuestion->question->text ?></h5>
                            <p class="card-text">Your answer :  <button class="btn btn-sm <?= $btnClass ?>"><b><?= $userAnswer->text ?></b></button></p>
                            <p class="card-text">Correct answer :  <b><?= $correctAnswer->text ?></b></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    window.sessionStorage.removeItem('my-counter');
</script>