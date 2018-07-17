<?php

use yii\db\Migration;

/**
 * Handles the creation of table `year`.
 */
class m180714_034400_create_year_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function SafeUp()
    {
        $this->createTable('year', [
            'year_id' => $this->primaryKey(),
            'year_label' => $this->string(10)->notNull(),
        ],'ENGINE=MyISAM');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('year');
    }
}
