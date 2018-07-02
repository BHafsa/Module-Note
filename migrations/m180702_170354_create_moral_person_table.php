<?php

use yii\db\Migration;

/**
 * Handles the creation of table `moral_person`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m180702_170354_create_moral_person_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('moral_person', [
            'moral_person_id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-moral_person-user_id',
            'moral_person',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-moral_person-user_id',
            'moral_person',
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
            'fk-moral_person-user_id',
            'moral_person'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-moral_person-user_id',
            'moral_person'
        );

        $this->dropTable('moral_person');
    }
}
