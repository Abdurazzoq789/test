<?php
/**
 * @var $model \common\models\Test
 */

$correctCount = $model->getTestCorrectAnswerCount();
?>

<h1><?= $model->title ?> Results </h1>
<div class="card">
    <div class="card-body">
        <div class="card-header">
            <p><span style="color: green">Correct answers count</span> : <b><?= (int)$correctCount ?></b>
                || <span style="color: red">Incorrect answers count</span> : <b><?= $model->count - $correctCount ?></b></p>
        </div>
        <div class="row my-row">
            <?php foreach ($model->testQuestions as $testQuestion) : ?>
                <?php
                $userAnswer = $testQuestion->getAnswersText();
                $correctAnswer = $testQuestion->question->getCorrectAnswerText();
                $btnClass = ($userAnswer['text'] == $correctAnswer['text']) ? 'btn-success' : 'btn-danger'
                ?>
                <div class="col-12 item-row">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $testQuestion->question->text ?></h5>
                            <p class="card-text">Your answer :  <span class="btn btn-sm <?= $btnClass ?>"><b><?= $userAnswer['text'] ?></b></span></p>
                            <p class="card-text">Correct answer :  <b><?= $correctAnswer['text'] ?></b></p>
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