<?php

use yii\db\Migration;

class uninstall extends Migration
{
    public function up()
    {
        $this->dropTable('grade');
        $this->dropTable('course');
        $this->dropTable('student');
        $this->dropTable('class_group');
        $this->dropTable('tbl_instructor_section');
        $this->dropTable('tbl_instructor_class_group');
        $this->dropTable('grade_report');
        $this->dropTable('section');
        $this->dropTable('educational_unit');
        $this->dropTable('level');
        $this->dropTable('moral_person');
        $this->dropTable('instructor');
    }

    public function down()
    {
        echo "uninstall does not support migration down.\n";
        return false;
    }

}
