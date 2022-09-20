<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\QuestionTag $model
 */

$this->title = $model->question_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Question Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-tag-view">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'question_id' => $model->question_id, 'tag_id' => $model->tag_id], ['class' => 'btn btn-primary']) ?>
            <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'question_id' => $model->question_id, 'tag_id' => $model->tag_id], [
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
                    'question_id',
                    'tag_id',
                    
                ],
            ]) ?>
        </div>
    </div>
</div>
