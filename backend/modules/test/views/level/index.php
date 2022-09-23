<?php

use common\grid\EnumColumn;
use common\models\Level;
use rmrevin\yii\fontawesome\FAS;
use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var backend\modules\test\models\search\LevelSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('backend', 'Levels');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="level-index">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
                'modelClass' => 'Level',
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
                    'class' => ['table', 'text-nowrap', 'table-striped', 'table-bordered', 'mb-0'],
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'name',
                    [
                        'class' => EnumColumn::class,
                        'attribute' => 'status',
                        'enum' => Level::getStatus(),
                        'filter' => Level::getStatus()
                    ],
                    [
                        'class' => \common\widgets\ActionColumn::class,
                        'template' => '{update} {delete}',
                        'options' => ['style' => 'width: 100px'],
                        'buttons' => [
                                'delete' => function ($url, $model){
                                    if ($model->status == Level::STATUS_ACTIVE){
                                        return Html::a(
                                            FAS::icon('trash', ['aria' => ['hidden' => true], 'class' => ['fa-fw']]),
                                            $url,
                                            [
                                                'title' => Yii::t('backend', 'Inactive'),
                                                'class' => ['btn', 'btn-xs', 'btn-danger'],
                                                'data-method' => 'post'
                                            ]
                                        );
                                    }

                                    return Html::a(
                                        FAS::icon('check', ['aria' => ['hidden' => true], 'class' => ['fa-fw']]),
                                        \yii\helpers\Url::to(['active', 'id' => $model->id]),
                                        [
                                            'title' => Yii::t('backend', 'Active'),
                                            'class' => ['btn', 'btn-xs', 'btn-primary']
                                        ]
                                    );
                                }
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
