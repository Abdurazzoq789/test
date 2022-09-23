<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%test}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m220920_053926_create_test_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%test}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'passing_score' => $this->float(),
            'started_at' => $this->integer(),
            'status' => $this->integer(),
            'deadline' => $this->integer(),
            'user_id' => $this->integer(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-test-user_id}}',
            '{{%test}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-test-user_id}}',
            '{{%test}}',
            'user_id',
            '{{%user}}',
            'id',
            'restrict'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-test-user_id}}',
            '{{%test}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-test-user_id}}',
            '{{%test}}'
        );

        $this->dropTable('{{%test}}');
    }
}
