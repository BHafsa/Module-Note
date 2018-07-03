<?php

use yii\db\Migration;

/**
 * Handles the creation of table `course`.
 * Has foreign keys to the tables:
 *
 * - `educational_unit`
 */
class m180702_174814_create_course_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('course', [
            'course_id' => $this->primaryKey(),
            'designation' => $this->string(30),
            'coefficient' => $this->integer(1)->notNull(),
            'credit' => $this->integer(10),
            'bonus' => $this->integer(10),
            'educational_unit_id' => $this->integer(),
        ]);

        // creates index for column `educational_unit_id`
        $this->createIndex(
            'idx-course-educational_unit_id',
            'course',
            'educational_unit_id'
        );

        // add foreign key for table `educational_unit`
        $this->addForeignKey(
            'fk-course-educational_unit_id',
            'course',
            'educational_unit_id',
            'educational_unit',
            'educational_unit_id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // drops foreign key for table `educational_unit`
        $this->dropForeignKey(
            'fk-course-educational_unit_id',
            'course'
        );

        // drops index for column `educational_unit_id`
        $this->dropIndex(
            'idx-course-educational_unit_id',
            'course'
        );

        $this->dropTable('course');
    }
}
