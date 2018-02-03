<?php

use yii\db\Migration;

class uninstall extends Migration
{

    public function up()
    {
        $this->dropTable('etudiant');
        $this->dropTable('enseignerGroupe');
        $this->dropTable('enseignerSection');
        $this->dropTable('personneMorale');
        $this->dropTable('enseignant');
        $this->dropTable('groupe');
        $this->dropTable('note');
        $this->dropTable('releve');
        $this->dropTable('section'); 
        $this->dropTable('module'); 
        $this->dropTable('ue');
        $this->dropTable('niveau'); 
    }

    public function down()
    {
        echo "uninstall does not support migration down.\n";
        return false;
    }

}
