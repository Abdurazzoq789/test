<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var backend\modules\test\models\search\TestQuestionSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('backend', 'Answers');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Tests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Results'), 'url' => ['result', 'id' => $_GET['test_id']]];
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
                    'class' => ['table', 'table-striped', 'table-bordered', 'mb-0'],
                ],
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'label' => 'Question',
                        'value' => function ($model) {
                            return $model->question->text;
                        }
                    ],
                    [
                        'label' => 'User Answer',
                        'value' => function ($model) {
                            return $model->testQuestionAnswer->answer->text;
                        }
                    ],
                    [
                        'label' => 'Correct Answer',
                        'value' => function ($model) {
                            return $model->question->correctAnswer->text;
                        }
                    ],
                    [
                        'label' => 'Correct',
                        'format' => 'html',
                        'value' => function ($model) {
                            if($model->question->correctAnswer->id == $model->testQuestionAnswer->answer->id){
                                return '<i class="fa-fw fas fa-check"></i>';
                            }
                            return '<i class="fa-fw fas fa-times"></i>';
                        }
                    ],
                ],
            ]); ?>

        </div>
        <div class="card-footer">
        </div>
    </div>

</div>
