<?php

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
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'title',
                    [
                        'attribute' => 'started_at',
                        'value' => function ($model) {
                            return Yii::$app->formatter->asDatetime($model->started_at, 'medium');
                        }
                    ],
                    'count',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'headerOptions' => ['style' => 'text-align:center;min-width:120px;max-width:220px;width:220px'],
                        'template' => '{buttons}',
                        'contentOptions' => ['style' => 'min-width:120px;max-width:220px;width:220px;text-align:center'],
                        'buttons' => [
                            'buttons' => function ($url, $model) {
                                $start = Url::to(['/test/begin', 'id' => $model->id]);
                                $result = Url::to(['/test/result', 'id' => $model->id]);
                                $code = '';
                                if ($model->status != \common\models\Test::STATUS_COMPETED) {
                                    $code = <<<BUTTONS
                                    <div>
                                        <a href="{$start}" data-pjax="0" class="btn btn-info btn-icon">
                                            <div>
                                                <i class="fa fa-check"></i>
                                            </div>
                                        </a>
                                    </div>
BUTTONS;
                                } else {
                                    $code = <<<BUTTONS
                                    <div>
                                        <a href="{$result}" data-pjax="0" class="btn btn-info btn-icon">
                                            <div>
                                                <i class="fa fa-eye"></i>
                                            </div>
                                        </a>
                                    </div>
BUTTONS;
                                }
                                return $code;
                            }

                        ],
                    ]
                ],
            ]); ?>

        </div>
        <div class="card-footer">
        </div>
    </div>

</div>
