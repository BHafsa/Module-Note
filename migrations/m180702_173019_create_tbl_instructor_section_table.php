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
    public function SafeUp()
    {
        $this->createTable('tbl_instructor_section', [
            'instructor_id' => $this->integer()->notNull(),
            'course_id' => $this->integer()->notNull(),
            'section_id' => $this->integer()->notNull(),
            'level_id' => $this->integer()->notNull(),
        ],'ENGINE=MyISAM');

        $this->addPrimaryKey('pk-tbl_instructor_section', 'tbl_instructor_section', ['instructor_id', 'course_id', 'section_id', 'level_id']);
        
        // creates index for column `instructor_id`
        $this->createIndex(
            'idx-tbl_instructor_section-instructor_id',
            'tbl_instructor_section',
            'instructor_id'
        );  
        // add foreign key for table `instructor`
        $this->addForeignKey(
            'fk-tbl_instructor_section-instructor_id',
            'tbl_instructor_section',
            'instructor_id',
            'instructor',
            'instructor_id',
            'CASCADE'
        );

        // creates index for column `course_id`
        $this->createIndex(
            'idx-tbl_instructor_section-course_id',
            'tbl_instructor_section',
            'course_id'
        );  
        // add foreign key for table `course`
        $this->addForeignKey(
            'fk-tbl_instructor_section-course_id',
            'tbl_instructor_section',
            'course_id',
            'course',
            'course_id',
            'CASCADE'
        );

        $this->createIndex(
            'index-tbl_instructor_section-section',
            'tbl_instructor_section',
            ['section_id', 'level_id']
        );

        $this->addForeignKey(
            'fk-tbl_instructor_section-section',
            'tbl_instructor_section',
            ['section_id', 'level_id'],
            'section',
            ['section_id', 'level_id'],
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('tbl_instructor_section');
    }
}
