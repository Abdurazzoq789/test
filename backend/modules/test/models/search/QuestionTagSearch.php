<?php

namespace backend\modules\test\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\QuestionTag;

/**
 * QuestionTagSearch represents the model behind the search form about `common\models\QuestionTag`.
 */
class QuestionTagSearch extends QuestionTag
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'tag_id'], 'integer'],
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
        $query = QuestionTag::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'question_id' => $this->question_id,
            'tag_id' => $this->tag_id,
        ]);

        return $dataProvider;
    }
}
