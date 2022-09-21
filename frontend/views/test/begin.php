<?php
/**
 * @var $testQuestion \common\models\TestQuestion
 * @var $model \common\models\TestQuestionAnswer
 */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

?>
<style>
    .custom-control-input.is-valid ~ .custom-control-label {
        color: black;
    }
</style>
<div class="test-index">

    <h1><?= $testQuestion->test->title ?></h1>

    <hr>
    <?php $form = ActiveForm::begin(); ?>
    <div class="card">
        <div class="card-body">
            <h4><b><?= $testQuestion->question->text ?> ?</b></h4>
            <div class="row">
                <?php foreach ($testQuestion->question->answers as $answerIndex => $answer) : ?>
                    <div class="col-6">
                        <input type="radio" name="TestQuestionAnswer[answer_id]" value="<?= $answer->id ?>"
                               id="<?= $answer->id ?>">
                        <label for="<?= $answer->id ?>"><?= $answer->text ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="card-footer">
            <?php echo Html::submitButton(Yii::t('frontend', 'Send'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>

