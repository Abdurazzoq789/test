<?php

namespace backend\modules\test\controllers;

use backend\modules\test\models\forms\TestForm;
use backend\modules\test\models\search\TestQuestionSearch;
use backend\modules\test\models\search\TestSearch;
use common\models\Test;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TestController implements the CRUD actions for Test model.
 */
class TestController extends Controller
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
     * Lists all Test models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionResult($id)
    {
        $model = $this->findModel($id);

        return $this->render('results', [
            'model' => $model
        ]);
    }

    public function actionAnswer($test_id, $correct = false)
    {
        $searchModel = new TestQuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->bodyParams);
        $dataProvider->query->andWhere(['test_id' => $test_id]);
        $dataProvider->query->joinWith('answers');
        if ($correct !== false) {
            $dataProvider->query->andWhere(['answer.correct' => $correct]);
        }

        return $this->render('answer', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Test model.
     * @param int $id ID
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Test model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->form(
            new TestForm(
                new Test()
            )
        );
    }

    public function actionUpdate($id)
    {
        return $this->form(
            new TestForm(
                $this->findModel($id)
            )
        );
    }

    public function form(TestForm $model){
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Test model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Test model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Test the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Test::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
