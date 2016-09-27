<?php

use yii\db\Migration;

/**
 * Handles the creation for table `{{%tree}}`.
 */
class m160927_090502_create_table_tree extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%tree}}', [

            'id' => $this->primaryKey()->notNull(),
            'name' => $this->string(255)->notNull(),
            'url' => $this->string(255),
            'tree_id' => $this->integer(11),
            'txt' => $this->text(),

        ]);
 
        // creates index for column `tree_id`
        $this->createIndex(
            'treee_fk1',
            '{{%tree}}',
            'tree_id'
        );

        // add foreign key for table `tree`
        $this->addForeignKey(
            'treee_fk1',
            '{{%tree}}',
            'tree_id',
            '{{%tree}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // drops foreign key for table `tree`
        $this->dropForeignKey(
            'treee_fk1',
            '{{%tree}}'
        );

        // drops index for column `tree_id`
        $this->dropIndex(
            'treee_fk1',
            '{{%tree}}'
        );

        $this->dropTable('{{%tree}}');
    }
}
