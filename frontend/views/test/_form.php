<?php

use dosamigos\selectize\SelectizeTextInput;
use kartik\widgets\DateTimePicker;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var \backend\modules\test\models\forms\TestForm $model
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
                    <?php echo $form->field($model, 'count')
                        ->textInput(['type' => 'number'])
                        ->label('Question Count')->hint('Available Question count '. \common\models\Question::getAllCount()) ?>
                    <?php echo $form->field($model, 'deadline')->textInput(['type' => 'number'])->label('Dead line fore test')->hint("Please write minutes") ?>

                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">

                    <?php echo $form->field($model, 'levelIds')->widget(\kartik\select2\Select2::class, [
                        'data' => \common\models\Level::getDropdownList(),
                        'options' => [
                            'placeholder' => 'Select Level for questions',
                            'multiple' => true,
                        ]
                    ])->label("Level") ?>

                    <?php echo $form->field($model, 'tagIds')->widget(\kartik\select2\Select2::class, [
                        'data' => \common\models\Tag::getDropdownList(),
                        'options' => [
                            'placeholder' => 'Select question tags',
                            'multiple' => true,
                        ]
                    ])->label("Tags") ?>

                </div>
                <div class="card-footer">
                    <?php echo Html::submitButton(Yii::t('backend', 'Create'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
