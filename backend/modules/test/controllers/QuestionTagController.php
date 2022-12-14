<?php

namespace backend\modules\test\controllers;

use Yii;
use common\models\QuestionTag;
use backend\modules\test\models\search\QuestionTagSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QuestionTagController implements the CRUD actions for QuestionTag model.
 */
class QuestionTagController extends Controller
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
     * Lists all QuestionTag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuestionTagSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single QuestionTag model.
     * @param int $question_id Question ID
     * @param int $tag_id Tag ID
     * @return mixed
     */
    public function actionView($question_id, $tag_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($question_id, $tag_id),
        ]);
    }

    /**
     * Creates a new QuestionTag model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new QuestionTag();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'question_id' => $model->question_id, 'tag_id' => $model->tag_id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing QuestionTag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $question_id Question ID
     * @param int $tag_id Tag ID
     * @return mixed
     */
    public function actionUpdate($question_id, $tag_id)
    {
        $model = $this->findModel($question_id, $tag_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'question_id' => $model->question_id, 'tag_id' => $model->tag_id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing QuestionTag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $question_id Question ID
     * @param int $tag_id Tag ID
     * @return mixed
     */
    public function actionDelete($question_id, $tag_id)
    {
        $this->findModel($question_id, $tag_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the QuestionTag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $question_id Question ID
     * @param int $tag_id Tag ID
     * @return QuestionTag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($question_id, $tag_id)
    {
        if (($model = QuestionTag::findOne(['question_id' => $question_id, 'tag_id' => $tag_id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
