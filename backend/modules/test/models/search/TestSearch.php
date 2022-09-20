<?php

namespace backend\modules\test\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Test;

/**
 * TestSearch represents the model behind the search form about `common\models\Test`.
 */
class TestSearch extends Test
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'started_at', 'status', 'deadline', 'user_id'], 'integer'],
            [['title'], 'safe'],
            [['passing_score'], 'number'],
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
        $query = Test::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'passing_score' => $this->passing_score,
            'started_at' => $this->started_at,
            'status' => $this->status,
            'deadline' => $this->deadline,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
