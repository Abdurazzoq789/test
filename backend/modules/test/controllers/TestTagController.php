<?php

namespace backend\modules\test\controllers;

use Yii;
use common\models\TestTag;
use backend\modules\test\models\search\TestTagSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TestTagController implements the CRUD actions for TestTag model.
 */
class TestTagController extends Controller
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
     * Lists all TestTag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestTagSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TestTag model.
     * @param int $test_id Test ID
     * @param int $tag_id Tag ID
     * @return mixed
     */
    public function actionView($test_id, $tag_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($test_id, $tag_id),
        ]);
    }

    /**
     * Creates a new TestTag model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TestTag();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'test_id' => $model->test_id, 'tag_id' => $model->tag_id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TestTag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $test_id Test ID
     * @param int $tag_id Tag ID
     * @return mixed
     */
    public function actionUpdate($test_id, $tag_id)
    {
        $model = $this->findModel($test_id, $tag_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'test_id' => $model->test_id, 'tag_id' => $model->tag_id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TestTag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $test_id Test ID
     * @param int $tag_id Tag ID
     * @return mixed
     */
    public function actionDelete($test_id, $tag_id)
    {
        $this->findModel($test_id, $tag_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TestTag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $test_id Test ID
     * @param int $tag_id Tag ID
     * @return TestTag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($test_id, $tag_id)
    {
        if (($model = TestTag::findOne(['test_id' => $test_id, 'tag_id' => $tag_id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
