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
    public function safeUp()
    {
        $this->createTable('section', [
            'section_id' => $this->integer()->notNull(),
            'level_id' => $this->integer()->notNull(),
            'section_name' => $this->string(10)->notNull(),
        ]);

        $this->addPrimaryKey('pk-section', 'section', ['section_id', 'level_id']);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('section');
    }
}
