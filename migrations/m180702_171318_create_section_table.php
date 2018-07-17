<?php

use yii\db\Migration;

/**
 * Handles the creation of table `section`.
 */
class m180702_171318_create_section_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function SafeUp()
    {
        $this->createTable('section', [
            'section_id' => $this->integer()->notNull(),
            'level_id' => $this->integer()->notNull(),
            'section_name' => $this->string(10)->notNull(),
        ],'ENGINE=MyISAM');

        $this->addPrimaryKey('pk-section', 'section', ['section_id', 'level_id']);

           // creates index for column `level_id`
           $this->createIndex(
            'idx-section-level_id',
            'section',
            'level_id'
        );

        // add foreign key for table `level`
        $this->addForeignKey(
            'fk-section-level_id',
            'section',
            'level_id',
            'level',
            'level_id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('section');
    }
}
