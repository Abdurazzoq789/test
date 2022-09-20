<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%level}}`.
 */
class m220920_054021_create_level_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%level}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%level}}');
    }
}
