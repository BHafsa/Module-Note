<?php

use yii\db\Migration;

/**
 * Handles the creation of table `student`.
 * Has foreign keys to the tables:
 *
 * - `class_group`
 * - `user`
 */
class m180702_174500_create_student_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('student', [
            'student_id' => $this->primaryKey(),
            'registration_number' => $this->string(15)->notNull()->unique(),
            'last_name' => $this->string(30)->notNull(),
            'first_name' => $this->string(30)->notNull(),
            'date_of_birth' => $this->date()->notNull(),
            'place_of_birth' => $this->string(15)->notNull(),
            'admission_date' => $this->date(),
            'class_group_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `class_group_id`
        $this->createIndex(
            'idx-student-class_group_id',
            'student',
            'class_group_id'
        );

        // add foreign key for table `class_group`
        $this->addForeignKey(
            'fk-student-class_group_id',
            'student',
            'class_group_id',
            'class_group',
            'class_group_id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-student-user_id',
            'student',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-student-user_id',
            'student',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // drops foreign key for table `class_group`
        $this->dropForeignKey(
            'fk-student-class_group_id',
            'student'
        );

        // drops index for column `class_group_id`
        $this->dropIndex(
            'idx-student-class_group_id',
            'student'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-student-user_id',
            'student'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-student-user_id',
            'student'
        );

        $this->dropTable('student');
    }
}
