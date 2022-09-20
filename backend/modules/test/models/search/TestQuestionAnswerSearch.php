<?php

namespace backend\modules\test\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TestQuestionAnswer;

/**
 * TestQuestionAnswerSearch represents the model behind the search form about `common\models\TestQuestionAnswer`.
 */
class TestQuestionAnswerSearch extends TestQuestionAnswer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['test_question_id', 'answer_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TestQuestionAnswer::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'test_question_id' => $this->test_question_id,
            'answer_id' => $this->answer_id,
        ]);

        return $dataProvider;
    }
}
