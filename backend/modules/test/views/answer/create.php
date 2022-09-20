<?php

/**
 * @var yii\web\View $this
 * @var common\models\Answer $model
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Answer',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Answers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
