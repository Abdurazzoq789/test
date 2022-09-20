<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\TestTag $model
 */

$this->title = $model->test_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Test Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-tag-view">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'test_id' => $model->test_id, 'tag_id' => $model->tag_id], ['class' => 'btn btn-primary']) ?>
            <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'test_id' => $model->test_id, 'tag_id' => $model->tag_id], [
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
                    'test_id',
                    'tag_id',
                    
                ],
            ]) ?>
        </div>
    </div>
</div>
