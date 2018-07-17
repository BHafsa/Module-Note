<?php

use yii\db\Migration;

/**
 * Handles the creation of table `grade`.
 */
class m180702_171757_create_grade_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function SafeUp()
    {
        $this->createTable('grade', [
            'student_id' => $this->integer()->notNull(),
            'instructor_id' => $this->integer()->notNull(),
            'course_id' => $this->integer()->notNull(),
            'test_id' => $this->integer()->notNull(),
            'value' => $this->float(6)->notNull(),
            'date' => 'year NOT NULL',
        ],'ENGINE=MyISAM');

        $this->addPrimaryKey('pk-grade', 'grade', ['student_id', 'course_id', 'test_id', 'date']);
   
        // creates index for column `student_id`
           $this->createIndex(
            'idx-grade-student_id',
            'grade',
            'student_id'
        );

        // add foreign key for table `student`
        $this->addForeignKey(
            'fk-grade-student_id',
            'grade',
            'student_id',
            'student',
            'student_id',
            'CASCADE'
        );

        // creates index for column `instructor_id`
        $this->createIndex(
            'idx-grade-instructor_id',
            'grade',
            'instructor_id'
        );  
        // add foreign key for table `instructor`
        $this->addForeignKey(
            'fk-grade-instructor_id',
            'grade',
            'instructor_id',
            'instructor',
            'instructor_id',
            'CASCADE'
        );

         // creates index for column `course_id`
         $this->createIndex(
            'idx-grade-course_id',
            'grade',
            'course_id'
        );  
        // add foreign key for table `course`
        $this->addForeignKey(
            'fk-grade-course_id',
            'grade',
            'course_id',
            'course',
            'course_id',
            'CASCADE'
        );

         // creates index for column `test_id`
         $this->createIndex(
            'idx-grade-test_id',
            'grade',
            'test_id'
        );  
        // add foreign key for table `test`
        $this->addForeignKey(
            'fk-grade-test_id',
            'grade',
            'test_id',
            'test',
            'test_id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('grade');
    }
}
