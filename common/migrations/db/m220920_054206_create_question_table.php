<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%question}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%level}}`
 */
class m220920_054206_create_question_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%question}}', [
            'id' => $this->primaryKey(),
            'text' => $this->text(),
            'score' => $this->float(),
            'level_id' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        // creates index for column `level_id`
        $this->createIndex(
            '{{%idx-question-level_id}}',
            '{{%question}}',
            'level_id'
        );

        // add foreign key for table `{{%level}}`
        $this->addForeignKey(
            '{{%fk-question-level_id}}',
            '{{%question}}',
            'level_id',
            '{{%level}}',
            'id',
            'restrict'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%level}}`
        $this->dropForeignKey(
            '{{%fk-question-level_id}}',
            '{{%question}}'
        );

        // drops index for column `level_id`
        $this->dropIndex(
            '{{%idx-question-level_id}}',
            '{{%question}}'
        );

        $this->dropTable('{{%question}}');
    }
}
