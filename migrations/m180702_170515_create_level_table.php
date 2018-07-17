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
    public function SafeUp()
    {
        $this->createTable('level', [
            'level_id' => $this->primaryKey(),
            'year_id' => $this->integer()->notNull(),
            'option_id' => $this->integer() ,
        ],'ENGINE=MyISAM');

          // creates index for column `year_id`
          $this->createIndex(
            'idx-level-year_id',
            'level',
            'year_id'
        );

        // add foreign key for table `year`
        $this->addForeignKey(
            'fk-level-year_id',
            'level',
            'year_id',
            'year',
            'year_id',
            'CASCADE'
        );

          // creates index for column `option_id`
          $this->createIndex(
            'idx-level-option_id',
            'level',
            'option_id'
        );

        // add foreign key for table `option`
        $this->addForeignKey(
            'fk-level-option_id',
            'level',
            'option_id',
            'option',
            'option_id',
            'CASCADE'
        );
         
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('level');
    }
}
