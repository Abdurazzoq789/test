<?php
/**
 * @var $testQuestion \common\models\TestQuestion
 */

use common\models\Answer;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$test = $testQuestion->test;
$correctCount = $testQuestion->question->getCorrectAnswer()->count();
$typeInput = ($correctCount > 1) ? 'checkbox' : 'radio';
?>
<style>
    .custom-control-input.is-valid ~ .custom-control-label {
        color: black;
    }
</style>
<div class="test-index">

    <h1><?= $test->title ?></h1>
    <span class="d-none deadline"><?= ($test->started_at + ($test->deadline * 60)) - time() ?></span>
    <hr>
    <?php $form = ActiveForm::begin(); ?>
    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <p class="alignleft">Question Count: <b><?= $test->count ?></b> || Current: <b><?= Answer::getAnswerdCount($testQuestion->test_id) + 1 ?></b></p>
                <p class="alignright timer" id="timer"></p>
                <div style="clear: both;"></div>
            </div>
            <h4><b><?= $testQuestion->question->text ?> ?</b></h4>
            <div class="row">
                <?php foreach ($testQuestion->question->answers as $answerIndex => $answer) : ?>
                    <div class="col-6">
                        <input type="<?= $typeInput ?>" name="BeginForm[answerIds][]" value="<?= $answer->id ?>"
                               id="<?= $answer->id ?>">
                        <label for="<?= $answer->id ?>"><?= $answer->text ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="card-footer">
            <a href="<?= \yii\helpers\Url::to(['skip', 'test_question_id' => $testQuestion->id]) ?>" class="btn btn-primary">Skip</a>
            <?php echo Html::submitButton(Yii::t('frontend', 'Send'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>

<script>
    window.onload = function () {
        var deadline = $('.deadline').text()
        console.log(deadline)
        var countDownTime = window.sessionStorage.getItem(COUNTER_KEY) || deadline;
        countDown(countDownTime, function () {
            location.reload();
        });
    };
</script>

