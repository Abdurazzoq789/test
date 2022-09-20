<?php

namespace backend\modules\test\controllers;

use Yii;
use common\models\TestQuestionAnswer;
use backend\modules\test\models\search\TestQuestionAnswerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TestQuestionAnswerController implements the CRUD actions for TestQuestionAnswer model.
 */
class TestQuestionAnswerController extends Controller
{

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all TestQuestionAnswer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestQuestionAnswerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TestQuestionAnswer model.
     * @param int $test_question_id Test Question ID
     * @param int $answer_id Answer ID
     * @return mixed
     */
    public function actionView($test_question_id, $answer_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($test_question_id, $answer_id),
        ]);
    }

    /**
     * Creates a new TestQuestionAnswer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TestQuestionAnswer();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'test_question_id' => $model->test_question_id, 'answer_id' => $model->answer_id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TestQuestionAnswer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $test_question_id Test Question ID
     * @param int $answer_id Answer ID
     * @return mixed
     */
    public function actionUpdate($test_question_id, $answer_id)
    {
        $model = $this->findModel($test_question_id, $answer_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'test_question_id' => $model->test_question_id, 'answer_id' => $model->answer_id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TestQuestionAnswer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $test_question_id Test Question ID
     * @param int $answer_id Answer ID
     * @return mixed
     */
    public function actionDelete($test_question_id, $answer_id)
    {
        $this->findModel($test_question_id, $answer_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TestQuestionAnswer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $test_question_id Test Question ID
     * @param int $answer_id Answer ID
     * @return TestQuestionAnswer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($test_question_id, $answer_id)
    {
        if (($model = TestQuestionAnswer::findOne(['test_question_id' => $test_question_id, 'answer_id' => $answer_id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
