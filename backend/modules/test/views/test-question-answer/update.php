<?php

/**
 * @var yii\web\View $this
 * @var common\models\TestQuestionAnswer $model
 */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Test Question Answer',
]) . ' ' . $model->test_question_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Test Question Answers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->test_question_id, 'url' => ['view', 'test_question_id' => $model->test_question_id, 'answer_id' => $model->answer_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="test-question-answer-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
