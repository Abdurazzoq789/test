<?php

/**
 * @var yii\web\View $this
 * @var common\models\QuestionTag $model
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Question Tag',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Question Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-tag-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
