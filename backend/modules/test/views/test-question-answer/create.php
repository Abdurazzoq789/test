<?php

/**
 * @var yii\web\View $this
 * @var common\models\TestQuestionAnswer $model
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Test Question Answer',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Test Question Answers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-question-answer-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
