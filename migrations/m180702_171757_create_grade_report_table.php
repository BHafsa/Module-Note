<?php

use yii\db\Migration;

/**
 * Handles the creation of table `grade_report`.
 */
class m180702_171757_create_grade_report_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('grade_report', [
            'student_id' => $this->integer()->notNull(),
            'course_id' => $this->integer()->notNull(),
            'grade_id' => $this->integer()->notNull(),
            'date' => 'year NOT NULL',
        ]);

        $this->addPrimaryKey('pk-grade_report', 'grade_report', ['student_id', 'course_id', 'grade_id', 'date']);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('grade_report');
    }
}
