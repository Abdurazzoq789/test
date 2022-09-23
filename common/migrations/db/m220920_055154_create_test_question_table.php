<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%test_question}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%test}}`
 * - `{{%question}}`
 */
class m220920_055154_create_test_question_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%test_question}}', [
            'id' => $this->primaryKey(),
            'test_id' => $this->integer(),
            'question_id' => $this->integer(),
        ]);

        // creates index for column `test_id`
        $this->createIndex(
            '{{%idx-test_question-test_id}}',
            '{{%test_question}}',
            'test_id'
        );

        // add foreign key for table `{{%test}}`
        $this->addForeignKey(
            '{{%fk-test_question-test_id}}',
            '{{%test_question}}',
            'test_id',
            '{{%test}}',
            'id',
            'restrict'
        );

        // creates index for column `question_id`
        $this->createIndex(
            '{{%idx-test_question-question_id}}',
            '{{%test_question}}',
            'question_id'
        );

        // add foreign key for table `{{%question}}`
        $this->addForeignKey(
            '{{%fk-test_question-question_id}}',
            '{{%test_question}}',
            'question_id',
            '{{%question}}',
            'id',
            'restrict'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%test}}`
        $this->dropForeignKey(
            '{{%fk-test_question-test_id}}',
            '{{%test_question}}'
        );

        // drops index for column `test_id`
        $this->dropIndex(
            '{{%idx-test_question-test_id}}',
            '{{%test_question}}'
        );

        // drops foreign key for table `{{%question}}`
        $this->dropForeignKey(
            '{{%fk-test_question-question_id}}',
            '{{%test_question}}'
        );

        // drops index for column `question_id`
        $this->dropIndex(
            '{{%idx-test_question-question_id}}',
            '{{%test_question}}'
        );

        $this->dropTable('{{%test_question}}');
    }
}
