<?php

use rmrevin\yii\fontawesome\FAS;
use yii\helpers\Html;
use yii\grid\GridView;

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
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?php echo GridView::widget([
                'layout' => "{items}\n{pager}",
                'options' => [
                    'class' => ['gridview', 'table-responsive'],
                ],
                'tableOptions' => [
                    'class' => ['table', 'table-striped', 'table-bordered', 'mb-0'],
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'title',
                    'count',
                    'deadline',
                     'user.username',

                    [
                        'class' => \common\widgets\ActionColumn::class,
                        'template' => '{view} {delete}',
                        'options' => ['style' => 'width: 140px'],
                        'buttons' => [
                                'view' => function ($url, $model){
                                    if ($model->status == \common\models\Test::STATUS_COMPETED){
                                        $newUrl = \yii\helpers\Url::to(['/test/test/result', 'id' => $model->id]);
                                    } else {
                                        $newUrl = '#';
                                    }
                                    return Html::a(
                                        FAS::icon('eye', ['aria' => ['hidden' => true], 'class' => ['fa-fw']]),
                                        $newUrl,
                                        [
                                            'title' => Yii::t('backend', 'View'),
                                            'class' => ['btn', 'btn-xs', 'btn-primary']
                                        ]
                                    );
                                }
                        ],
                        'visibleButtons' => [
                            'login' => Yii::$app->user->can('administrator')
                        ]

                    ],
                ],
            ]); ?>

        </div>
        <div class="card-footer">
            <?php echo getDataProviderSummary($dataProvider) ?>
        </div>
    </div>

</div>
