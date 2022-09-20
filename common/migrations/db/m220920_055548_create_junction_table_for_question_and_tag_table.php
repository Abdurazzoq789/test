<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%question_tag}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%question}}`
 * - `{{%tag}}`
 */
class m220920_055548_create_junction_table_for_question_and_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%question_tag}}', [
            'question_id' => $this->integer(),
            'tag_id' => $this->integer(),
            'PRIMARY KEY(question_id, tag_id)',
        ]);

        // creates index for column `question_id`
        $this->createIndex(
            '{{%idx-question_tag-question_id}}',
            '{{%question_tag}}',
            'question_id'
        );

        // add foreign key for table `{{%question}}`
        $this->addForeignKey(
            '{{%fk-question_tag-question_id}}',
            '{{%question_tag}}',
            'question_id',
            '{{%question}}',
            'id',
            'CASCADE'
        );

        // creates index for column `tag_id`
        $this->createIndex(
            '{{%idx-question_tag-tag_id}}',
            '{{%question_tag}}',
            'tag_id'
        );

        // add foreign key for table `{{%tag}}`
        $this->addForeignKey(
            '{{%fk-question_tag-tag_id}}',
            '{{%question_tag}}',
            'tag_id',
            '{{%tag}}',
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
            '{{%fk-question_tag-question_id}}',
            '{{%question_tag}}'
        );

        // drops index for column `question_id`
        $this->dropIndex(
            '{{%idx-question_tag-question_id}}',
            '{{%question_tag}}'
        );

        // drops foreign key for table `{{%tag}}`
        $this->dropForeignKey(
            '{{%fk-question_tag-tag_id}}',
            '{{%question_tag}}'
        );

        // drops index for column `tag_id`
        $this->dropIndex(
            '{{%idx-question_tag-tag_id}}',
            '{{%question_tag}}'
        );

        $this->dropTable('{{%question_tag}}');
    }
}
