<?php

use dosamigos\selectize\SelectizeTextInput;
use kartik\widgets\DateTimePicker;
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
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <?php echo $form->errorSummary($model); ?>

                    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                    <?php echo $form->field($model, 'passing_score')->textInput() ?>
                    <?php echo $form->field($model, 'status')->dropdownList(\common\models\Test::getStatus()) ?>
                    <?php echo $form->field($model, 'count')->textInput(['type' => 'number']) ?>

                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">

                    <?php echo $form->field($model, 'started_at')->widget(DateTimePicker::class, [
                        'options' => ['placeholder' => 'Enter start time ...'],
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ]) ?>
                    <?php echo $form->field($model, 'deadline')->textInput(['type' => 'number']) ?>
                    <?php echo $form->field($model, 'user_id')->widget(\kartik\select2\Select2::class, [
                        'data' => \common\models\User::getDropdownList(),
                        'options' => [
                            'placeholder' => 'Select User'
                        ]
                    ]) ?>

                    <?php echo $form->field($model, 'level')->widget(\kartik\select2\Select2::class, [
                        'data' => \common\models\Level::getDropdownList(),
                        'options' => [
                            'placeholder' => 'Select Level for questions'
                        ]
                    ]) ?>
                    <?= $form->field($model, 'tagNames')->widget(SelectizeTextInput::class, [
                        // calls an action that returns a JSON object with matched
                        // tags
                        'loadUrl' => ['question/tag-list'],
                        'options' => ['class' => 'form-control'],
                        'clientOptions' => [
                            'plugins' => ['remove_button'],
                            'valueField' => 'name',
                            'labelField' => 'name',
                            'searchField' => ['name'],
                            'create' => true,
                        ],
                    ]) ?>

                </div>
                <div class="card-footer">
                    <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
