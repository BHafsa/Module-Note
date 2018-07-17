<?php

use yii\db\Migration;

/**
 * Handles the creation of table `educational_unit`.
 * Has foreign keys to the tables:
 *
 * - `level`
 */
class m180702_170953_create_educational_unit_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function SafeUp()
    {
        $this->createTable('educational_unit', [
            'educational_unit_id' => $this->primaryKey(),
            'code' => $this->string(10)->notNull(),
            'semester' => $this->boolean(),
        ],'ENGINE=MyISAM');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // drops foreign key for table `level`
        $this->dropForeignKey(
            'fk-educational_unit-level_id',
            'educational_unit'
        );

        // drops index for column `level_id`
        $this->dropIndex(
            'idx-educational_unit-level_id',
            'educational_unit'
        );

        $this->dropTable('educational_unit');
    }
}
