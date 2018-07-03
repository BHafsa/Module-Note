<?php

use yii\db\Migration;

/**
 * Handles the creation of table `class_group`.
 */
class m180702_173416_create_class_group_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('class_group', [
            'class_group_id' => $this->primaryKey(),
            'number' => $this->integer(5)->notNull(),
            'section_id' => $this->integer()->notNull(),
            'level_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'index-class_group-section',
            'class_group',
            ['section_id', 'level_id']
        );

        $this->addForeignKey(
            'fk-class_group-section',
            'class_group',
            ['section_id', 'level_id'],
            'section',
            ['section_id', 'level_id'],
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('class_group');
    }
}
