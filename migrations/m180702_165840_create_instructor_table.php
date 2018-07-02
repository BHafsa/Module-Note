<?php

use yii\db\Migration;

/**
 * Handles the creation of table `instructor`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m180702_165840_create_instructor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('instructor', [
            'instructor_id' => $this->primaryKey(),
            'last_name' => $this->string(30)->notNull(),
            'first_name' => $this->string(30)->notNull(),
            'registration_number' => $this->string(15)->notNull()->unique(),
            'user_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-instructor-user_id',
            'instructor',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-instructor-user_id',
            'instructor',
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
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-instructor-user_id',
            'instructor'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-instructor-user_id',
            'instructor'
        );

        $this->dropTable('instructor');
    }
}
