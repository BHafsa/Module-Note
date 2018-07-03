<?php

use yii\db\Migration;

/**
 * Handles the creation of table `grade`.
 */
class m180702_174914_create_grade_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('grade', [
            'grade_id' => $this->primaryKey(),
            'value' => $this->float(6),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('grade');
    }
}
