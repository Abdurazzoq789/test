<?php

/**
 * @var yii\web\View $this
 * @var common\models\TestTag $model
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Test Tag',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Test Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-tag-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
