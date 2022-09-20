<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\TestQuestionAnswer $model
 */

$this->title = $model->test_question_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Test Question Answers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-question-answer-view">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'test_question_id' => $model->test_question_id, 'answer_id' => $model->answer_id], ['class' => 'btn btn-primary']) ?>
            <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'test_question_id' => $model->test_question_id, 'answer_id' => $model->answer_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <div class="card-body">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'test_question_id',
                    'answer_id',
                    
                ],
            ]) ?>
        </div>
    </div>
</div>
