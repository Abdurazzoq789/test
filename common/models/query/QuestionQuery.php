<?php

namespace common\models\query;

use common\models\Question;

/**
 * This is the ActiveQuery class for [[\common\models\Question]].
 *
 * @see \common\models\Question
 */
class QuestionQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['status' => Question::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Question[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Question|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
