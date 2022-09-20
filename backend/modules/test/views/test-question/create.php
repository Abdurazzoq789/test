<?php

/**
 * @var yii\web\View $this
 * @var common\models\TestQuestion $model
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Test Question',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Test Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-question-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
