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
    public function safeUp()
    {
        $this->createTable('tbl_instructor_class_group', [
            'instructor_id' => $this->integer()->notNull(),
            'course_id' => $this->integer()->notNull(),
            'class_group_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pk-tbl_instructor_class_group', 'tbl_instructor_class_group', ['instructor_id', 'course_id', 'class_group_id']);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('tbl_instructor_class_group');
    }
}
