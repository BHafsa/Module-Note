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
    public function safeUp()
    {
        $this->createTable('educational_unit', [
            'educational_unit_id' => $this->primaryKey(),
            'code' => $this->string(10)->notNull(),
            'nature' => $this->string(30)->notNull(),
            'semester' => $this->boolean(),
            'level_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `level_id`
        $this->createIndex(
            'idx-educational_unit-level_id',
            'educational_unit',
            'level_id'
        );

        // add foreign key for table `level`
        $this->addForeignKey(
            'fk-educational_unit-level_id',
            'educational_unit',
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
