<?php

/**
 * @var yii\web\View $this
 * @var common\models\Level $model
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Level',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Levels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="level-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
