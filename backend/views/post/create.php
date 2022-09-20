<?php

/**
 * @var yii\web\View $this
 * @var common\models\Post $model
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Post',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
