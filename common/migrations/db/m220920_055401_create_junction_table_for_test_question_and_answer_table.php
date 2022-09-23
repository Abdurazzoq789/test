<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%test_question_answer}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%test_question}}`
 * - `{{%answer}}`
 */
class m220920_055401_create_junction_table_for_test_question_and_answer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%test_question_answer}}', [
            'test_question_id' => $this->integer(),
            'answer_id' => $this->integer(),
            'PRIMARY KEY(test_question_id, answer_id)',
        ]);

        // creates index for column `test_question_id`
        $this->createIndex(
            '{{%idx-test_question_answer-test_question_id}}',
            '{{%test_question_answer}}',
            'test_question_id'
        );

        // add foreign key for table `{{%test_question}}`
        $this->addForeignKey(
            '{{%fk-test_question_answer-test_question_id}}',
            '{{%test_question_answer}}',
            'test_question_id',
            '{{%test_question}}',
            'id',
            'restrict'
        );

        // creates index for column `answer_id`
        $this->createIndex(
            '{{%idx-test_question_answer-answer_id}}',
            '{{%test_question_answer}}',
            'answer_id'
        );

        // add foreign key for table `{{%answer}}`
        $this->addForeignKey(
            '{{%fk-test_question_answer-answer_id}}',
            '{{%test_question_answer}}',
            'answer_id',
            '{{%answer}}',
            'id',
            'restrict'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%test_question}}`
        $this->dropForeignKey(
            '{{%fk-test_question_answer-test_question_id}}',
            '{{%test_question_answer}}'
        );

        // drops index for column `test_question_id`
        $this->dropIndex(
            '{{%idx-test_question_answer-test_question_id}}',
            '{{%test_question_answer}}'
        );

        // drops foreign key for table `{{%answer}}`
        $this->dropForeignKey(
            '{{%fk-test_question_answer-answer_id}}',
            '{{%test_question_answer}}'
        );

        // drops index for column `answer_id`
        $this->dropIndex(
            '{{%idx-test_question_answer-answer_id}}',
            '{{%test_question_answer}}'
        );

        $this->dropTable('{{%test_question_answer}}');
    }
}
