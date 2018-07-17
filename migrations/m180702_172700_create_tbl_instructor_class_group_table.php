<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tbl_instructor_class_group`.
 */
class m180702_172700_create_tbl_instructor_class_group_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function SafeUp()
    {
        $this->createTable('tbl_instructor_class_group', [
            'instructor_id' => $this->integer()->notNull(),
            'course_id' => $this->integer()->notNull(),
            'class_group_id' => $this->integer()->notNull(),
        ],'ENGINE=MyISAM');

        $this->addPrimaryKey('pk-tbl_instructor_class_group', 'tbl_instructor_class_group', ['instructor_id', 'course_id', 'class_group_id']);
       
          // creates index for column `instructor_id`
          $this->createIndex(
            'idx-tbl_instructor_class_group-instructor_id',
            'tbl_instructor_class_group',
            'instructor_id'
        );  
        // add foreign key for table `instructor`
        $this->addForeignKey(
            'fk-tbl_instructor_class_group-instructor_id',
            'tbl_instructor_class_group',
            'instructor_id',
            'instructor',
            'instructor_id',
            'CASCADE'
        );

         // creates index for column `course_id`
         $this->createIndex(
            'idx-tbl_instructor_class_group-course_id',
            'tbl_instructor_class_group',
            'course_id'
        );  
        // add foreign key for table `course`
        $this->addForeignKey(
            'fk-tbl_instructor_class_group-course_id',
            'tbl_instructor_class_group',
            'course_id',
            'course',
            'course_id',
            'CASCADE'
        );

         // creates index for column `class_group_id`
         $this->createIndex(
            'idx-tbl_instructor_class_group-class_group_id',
            'tbl_instructor_class_group',
            'class_group_id'
        );  
        // add foreign key for table `class_group`
        $this->addForeignKey(
            'fk-tbl_instructor_class_group-class_group_id',
            'tbl_instructor_class_group',
            'class_group_id',
            'class_group',
            'class_group_id',
            'CASCADE'
        );


    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('tbl_instructor_class_group');
    }
}
