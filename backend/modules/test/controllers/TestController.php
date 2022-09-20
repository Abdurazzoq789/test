<?php

namespace backend\modules\test\controllers;

use common\models\Question;
use common\models\TestQuestion;
use Yii;
use common\models\Test;
use backend\modules\test\models\search\TestSearch;
use yii\db\Query;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        $model = new Test();

        if ($model->load(Yii::$app->request->post())) {
            $model->started_at = strtotime($model->started_at);
            if ($model->save()) {
                $questions = Question::find()
                    ->andWhere(['level_id' => $model->level])
                    ->orderBy('rand()')
                    ->limit($model->count)->all();
                foreach ($questions as $index => $question) {
                    $testQuestion = new TestQuestion([
                        'test_id' => $model->id,
                        'question_id' => $question->id
                    ]);

                    $testQuestion->save();
                }
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Test model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->started_at = strtotime($model->started_at);
            if ($model->save()) {
                TestQuestion::deleteAll(['test_id' => $model->id]);
                $questions = Question::find()
                    ->andWhere(['level_id' => $model->level])
                    ->orderBy('rand()')
                    ->limit($model->count)->all();
                foreach ($questions as $index => $question) {
                    $testQuestion = new TestQuestion([
                        'test_id' => $model->id,
                        'question_id' => $question->id
                    ]);

                    $testQuestion->save();
                }
                return $this->redirect(['index']);
            }
        }
        $model->started_at = Yii::$app->formatter->asDatetime($model->started_at, 'php:Y-m-d H:i:s');
        $model->tagNames = (new Query())->select(['group_concat(name separator ",") as name'])
            ->from("tag")
            ->leftJoin("test_tag", "test_tag.tag_id = tag.id")
            ->andWhere(['test_tag.test_id' => $id])
            ->one()['name'];
        return $this->render('update', [
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
