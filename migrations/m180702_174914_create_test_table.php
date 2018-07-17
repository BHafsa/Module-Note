<?php

use yii\db\Migration;

/**
 * Handles the creation of table `test`.
 */
class m180702_174914_create_test_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function SafeUp()
    {
        $this->createTable('test', [
            'test_id' => $this->primaryKey(),
            'test_coef' => $this->float(6)->notNull(),
            'test_label' => $this->string(15)->notNull(),
        ],'ENGINE=MyISAM');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('test');
    }
}
