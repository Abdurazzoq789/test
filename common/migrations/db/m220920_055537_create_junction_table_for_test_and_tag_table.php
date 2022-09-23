<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%test_tag}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%test}}`
 * - `{{%tag}}`
 */
class m220920_055537_create_junction_table_for_test_and_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%test_tag}}', [
            'test_id' => $this->integer(),
            'tag_id' => $this->integer(),
            'PRIMARY KEY(test_id, tag_id)',
        ]);

        // creates index for column `test_id`
        $this->createIndex(
            '{{%idx-test_tag-test_id}}',
            '{{%test_tag}}',
            'test_id'
        );

        // add foreign key for table `{{%test}}`
        $this->addForeignKey(
            '{{%fk-test_tag-test_id}}',
            '{{%test_tag}}',
            'test_id',
            '{{%test}}',
            'id',
            'restrict'
        );

        // creates index for column `tag_id`
        $this->createIndex(
            '{{%idx-test_tag-tag_id}}',
            '{{%test_tag}}',
            'tag_id'
        );

        // add foreign key for table `{{%tag}}`
        $this->addForeignKey(
            '{{%fk-test_tag-tag_id}}',
            '{{%test_tag}}',
            'tag_id',
            '{{%tag}}',
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
            '{{%fk-test_tag-test_id}}',
            '{{%test_tag}}'
        );

        // drops index for column `test_id`
        $this->dropIndex(
            '{{%idx-test_tag-test_id}}',
            '{{%test_tag}}'
        );

        // drops foreign key for table `{{%tag}}`
        $this->dropForeignKey(
            '{{%fk-test_tag-tag_id}}',
            '{{%test_tag}}'
        );

        // drops index for column `tag_id`
        $this->dropIndex(
            '{{%idx-test_tag-tag_id}}',
            '{{%test_tag}}'
        );

        $this->dropTable('{{%test_tag}}');
    }
}
