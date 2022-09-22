<?php

use common\models\Answer;
use dosamigos\selectize\SelectizeTextInput;
use unclead\multipleinput\components\BaseColumn;
use unclead\multipleinput\MultipleInput;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Question $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="question-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <?= $form->errorSummary($model) ?>

                    <?php echo $form->field($model, 'text')->textarea(['rows' => 4]) ?>

                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">

                    <?php echo $form->field($model, 'level_id')->dropdownList(\common\models\Level::getDropdownList(), [
                        'prompt' => [
                            'text' => 'Select Level',
                            'options' => []
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
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?= $form->field($model, 'answers')->widget(MultipleInput::class, [
                        'max' => 10,
                        'cloneButton' => true,
                        'iconSource' => MultipleInput::ICONS_SOURCE_FONTAWESOME,
                        'iconMap' => [
                            MultipleInput::ICONS_SOURCE_FONTAWESOME => [
                                'drag-handle' => 'fa fa-bars',
                                'remove' => 'fa fa-times',
                                'add' => 'fa fa-plus',
                                'clone' => 'fa fa-file',
                            ],
                        ],
                        'columns' => [
                            [
                                'name' => 'text',
                                'type' => 'textArea',
                                'title' => 'Text',
                            ],
                            [
                                'name' => 'correct',
                                'type' => 'dropDownList',
                                'title' => 'Correct',
                                'items' => [
                                    Answer::ANSWER_INCORRECT => 'InCorrect',
                                    Answer::ANSWER_CORRECT => 'Correct'
                                ],
                            ],
                        ]
                    ])->label(false); ?>
                </div>
                <div class="card-footer">
                    <?php echo Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
