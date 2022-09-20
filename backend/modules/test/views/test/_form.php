<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\Test $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="test-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->errorSummary($model); ?>

                <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'passing_score')->textInput() ?>
                <?php echo $form->field($model, 'started_at')->textInput() ?>
                <?php echo $form->field($model, 'status')->textInput() ?>
                <?php echo $form->field($model, 'deadline')->textInput() ?>
                <?php echo $form->field($model, 'user_id')->textInput() ?>
                
            </div>
            <div class="card-footer">
                <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
