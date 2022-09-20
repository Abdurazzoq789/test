<?php

namespace backend\modules\test\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TestTag;

/**
 * TestTagSearch represents the model behind the search form about `common\models\TestTag`.
 */
class TestTagSearch extends TestTag
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['test_id', 'tag_id'], 'integer'],
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
        $query = TestTag::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'test_id' => $this->test_id,
            'tag_id' => $this->tag_id,
        ]);

        return $dataProvider;
    }
}
