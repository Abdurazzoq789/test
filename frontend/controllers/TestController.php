<?php

namespace frontend\controllers;

use backend\modules\test\models\search\TestQuestionSearch;
use backend\modules\test\models\search\TestSearch;
use common\models\Article;
use common\models\ArticleCategory;
use common\models\ArticleAttachment;
use common\models\Test;
use common\models\TestQuestion;
use common\models\TestQuestionAnswer;
use frontend\models\search\ArticleSearch;
use Yii;
use yii\base\Model;
use yii\db\Query;
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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBegin($id)
    {
        $test = $this->findModel($id);
        $model = new TestQuestionAnswer();
        $subQuery = (new Query())->select('test_question_id')
            ->from('test_question_answer');

        $testQuestion = TestQuestion::find()
            ->andWhere(['test_id' => $test->id])
            ->andWhere(['not in', 'id', $subQuery])
            ->one();


        if ($testQuestion == null || $test->status == Test::STATUS_COMPETED) {
            $test->updateAttributes(['status' => Test::STATUS_COMPETED]);
            return $this->render('result', [
                'model' => $test
            ]);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->test_question_id = $testQuestion->id;
            if ($model->save()) {
                return $this->refresh();
            }
        }


        return $this->render('begin', [
            'testQuestion' => $testQuestion,
            'model' => $model
        ]);
    }

    public function actionResult($id)
    {
        $model = $this->findModel($id);

        return $this->render('result', [
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

    protected function findModel($id)
    {
        if (($model = Test::findOne(['id' => $id, 'user_id' => Yii::$app->user->getId()])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
