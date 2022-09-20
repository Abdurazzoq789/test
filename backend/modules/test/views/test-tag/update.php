<?php

/**
 * @var yii\web\View $this
 * @var common\models\TestTag $model
 */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Test Tag',
]) . ' ' . $model->test_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Test Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->test_id, 'url' => ['view', 'test_id' => $model->test_id, 'tag_id' => $model->tag_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="test-tag-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
