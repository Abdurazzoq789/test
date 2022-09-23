<?php

use common\grid\EnumColumn;
use common\models\Question;
use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var backend\modules\test\models\search\QuestionSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('backend', 'Questions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-index">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
                'modelClass' => 'Question',
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
                    'text',
                    [
                        'attribute' => 'level.name',
                        'options' => ['style' => 'width: 80px'],
                    ],
                    [
                        'class' => EnumColumn::class,
                        'attribute' => 'status',
                        'enum' => Question::getStatus(),
                        'filter' => Question::getStatus()
                    ],

                    [
                        'class' => \common\widgets\ActionColumn::class,
                        'template' => '{update} {delete}',
                        'options' => ['style' => 'width: 100px'],
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
