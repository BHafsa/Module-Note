<?php

use yii\db\Migration;

/**
 * Handles the creation of table `option`.
 */
class m180714_034604_create_option_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function SafeUp()
    {
        $this->createTable('option', [
            'option_id' => $this->primaryKey(),
            'option_label' => $this->string(10)->notNull(),
        ],'ENGINE=MyISAM');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('option');
    }
}
