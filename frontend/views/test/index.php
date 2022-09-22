<?php

use rmrevin\yii\fontawesome\FAS;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var backend\modules\test\models\search\TestSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('backend', 'Tests');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-index">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
                'modelClass' => 'Test',
            ]), ['create'], ['class' => 'btn btn-success']) ?>
        </div>

        <div class="card-body p-0">
            <?php echo GridView::widget([
                'layout' => "{items}\n{pager}",
                'options' => [
                    'class' => ['gridview', 'table-responsive'],
                ],
                'tableOptions' => [
                    'class' => ['table', 'text-nowrap', 'table-striped', 'table-bordered', 'mb-0'],
                ],
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'title',
                    [
                        'attribute' => 'deadline',
                        'value' => function ($model) {
                            return $model->deadline . ' Minutes';
                        }
                    ],
                    'count',
                    [
                        'label' => 'Correct Answer Count',
                        'value' => function ($model) {
                            return $model->getTestResult();
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{buttons}',
                        'options' => ['style' => 'width: 140px'],
                        'buttons' => [
                            'buttons' => function ($url, $model) {
                                $start = Url::to(['/test/begin', 'id' => $model->id]);
                                $result = Url::to(['/test/result', 'id' => $model->id]);
                                $code = '';
                                if ($model->status != \common\models\Test::STATUS_COMPETED) {
                                    $code = <<<BUTTONS
                                    <div>
                                        <a href="{$start}"  data-deadline="{$model->deadline}" data-pjax="0" class="btn btn-success">
                                                <i class="fa fa-check"></i>
                                        </a>
                                    </div>
BUTTONS;
                                } else {
                                    $code = <<<BUTTONS
                                    <div>
                                        <a href="{$result}" data-pjax="0" class="btn btn-primary">
                                                <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
BUTTONS;
                                }
                                return $code;
                            },
                        ],
                    ]
                ],
            ]); ?>

        </div>
        <div class="card-footer">
        </div>
    </div>

</div>
