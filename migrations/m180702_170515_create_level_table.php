<?php

use yii\db\Migration;

/**
 * Handles the creation of table `level`.
 */
class m180702_170515_create_level_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('level', [
            'level_id' => $this->primaryKey(),
            'year' => $this->string(10)->notNull(),
            'option' => $this->string(20)->null(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('level');
    }
}
