<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tbl_instructor_section`.
 */
class m180702_173019_create_tbl_instructor_section_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('tbl_instructor_section', [
            'instructor_id' => $this->integer()->notNull(),
            'course_id' => $this->integer()->notNull(),
            'section_id' => $this->integer()->notNull(),
            'level_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pk-tbl_instructor_section', 'tbl_instructor_section', ['instructor_id', 'course_id', 'section_id', 'level_id']);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('tbl_instructor_section');
    }
}
