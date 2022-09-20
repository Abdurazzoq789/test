<?php

/**
 * @var yii\web\View $this
 * @var common\models\QuestionTag $model
 */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Question Tag',
]) . ' ' . $model->question_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Question Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->question_id, 'url' => ['view', 'question_id' => $model->question_id, 'tag_id' => $model->tag_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="question-tag-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
