<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%tag}}`.
 */
class m220920_080509_add_frequency_column_to_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tag}}', 'frequency', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%tag}}', 'frequency');
    }
}
