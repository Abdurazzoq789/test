<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%answer}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%question}}`
 */
class m220920_054652_create_answer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%answer}}', [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer(),
            'text' => $this->text(),
            'sort' => $this->integer(),
            'correct' => $this->boolean(),
            'status' => $this->integer(),
        ]);

        // creates index for column `question_id`
        $this->createIndex(
            '{{%idx-answer-question_id}}',
            '{{%answer}}',
            'question_id'
        );

        // add foreign key for table `{{%question}}`
        $this->addForeignKey(
            '{{%fk-answer-question_id}}',
            '{{%answer}}',
            'question_id',
            '{{%question}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%question}}`
        $this->dropForeignKey(
            '{{%fk-answer-question_id}}',
            '{{%answer}}'
        );

        // drops index for column `question_id`
        $this->dropIndex(
            '{{%idx-answer-question_id}}',
            '{{%answer}}'
        );

        $this->dropTable('{{%answer}}');
    }
}
