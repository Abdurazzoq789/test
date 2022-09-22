<?php

namespace frontend\controllers;

use backend\modules\test\models\forms\TestForm;
use backend\modules\test\models\search\TestQuestionSearch;
use backend\modules\test\models\search\TestSearch;
use common\models\Test;
use common\models\TestQuestion;
use frontend\models\forms\BeginForm;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class TestController extends Controller
{
    /**
     * Lists all Test models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $searchModel = new TestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query->andWhere(['test.user_id' => Yii::$app->user->getId()]);
        $dataProvider->query->orderBy(['status' => SORT_ASC, 'started_at' => SORT_DESC]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBegin($id)
    {
        $test = $this->findModel($id);
        $model = new BeginForm($test);

        if ($model->done) {
            return $this->redirect(['result', 'id' => $model->test->id]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->refresh();
        }

        return $this->render('begin', [
            'testQuestion' => $model->testQuestion,
        ]);
    }

    public function actionResult($id)
    {
        $model = $this->findModel($id);

        return $this->render('results', [
            'model' => $model
        ]);
    }

    public function actionSkip($test_question_id)
    {
        $model = TestQuestion::findOne($test_question_id);

        $model->updateAttributes(['status' => TestQuestion::STATUS_SKIP]);

        return $this->redirect(['begin', 'id' => $model->test_id]);
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

    protected function findModel($id)
    {
        if (($model = Test::findOne(['id' => $id, 'user_id' => Yii::$app->user->getId()])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCreate()
    {
        return $this->form(
            new TestForm(
                new Test(['user_id' => Yii::$app->user->id])
            )
        );
    }

    public function form(TestForm $model)
    {
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
}
