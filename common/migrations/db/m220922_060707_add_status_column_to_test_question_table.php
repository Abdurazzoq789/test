<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%test_question}}`.
 */
class m220922_060707_add_status_column_to_test_question_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%test_question}}', 'status', $this->integer()->defaultValue(\common\models\TestQuestion::STATUS_ACTIVE));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%test_question}}', 'status');
    }
}
