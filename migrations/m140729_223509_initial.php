<?php

use humhub\components\Migration;

class m140729_223509_initial extends Migration
{

    public function up()
    {

         $this->createTable('enseignant', array(
            'idEnseignant' => 'pk',
            'nom' => 'varchar(30) NOT NULL',
            'prenom' => 'varchar(30) NOT NULL',
            'matricule' => 'varchar(15) NOT NULL UNIQUE',
            'id' => 'int(11) NOT NULL',
                ),'' );

         $this->addForeignKey(
            'fk-enseignant-user_id',
            'enseignant',
            'id',
            'user',
            'id',
            'CASCADE'
        );

         $this->createTable('personneMorale', array(
            'idPersonneMorale' => 'pk',
            'id' => 'int(11) NOT NULL',
                ), ''); 

         $this->addForeignKey(
            'fk-personneMorale-user_id',
            'personneMorale',
            'id',
            'user',
            'id',
            'CASCADE'
        );

          $this->createTable('niveau', array(
            'idNiveau' => 'pk',
            'anne' => 'varchar(10) NOT NULL',
            'specialite' => 'varchar(20) NULL',
                ), '');

          $this->createTable('UE', array(
            'idUE' => 'pk',
            'Code' => 'varchar(10) NOT NULL',
            'Nature' => 'varchar(30) NOT NULL',
            'semestre'=> 'boolean',
            'idNiveau' => 'int(11) NOT NULL',
                ), '');

           $this->addForeignKey(
            'fk-ue-niveau_id',
            'ue',
            'idNiveau',
            'niveau',
            'idNiveau',
            'CASCADE'
        );

          $this->createTable('section', array(
            'idSection' => 'int(11) NOT NULL',
            'idNiveau' => 'int(11) NOT NULL',
            'PRIMARY KEY (`idNiveau`,`idSection`)',
            'nomSection' => 'varchar(10) NOT NULL',
                ), '');

          $this->createTable('releve', array(
            'idEtudiant' => 'int(11) NOT NULL',
            'idModule' => 'int(11) NOT NULL',
            'idNote' => 'int(11) NOT NULL',
            'date' => 'year NOT NULL',
            'PRIMARY KEY (`idEtudiant`,`idNote`,`idModule`,`date`)',
            
                ), '');

           $this->createTable('enseignerGroupe', array(
            'idEnseignant' => 'int(11)  NOT NULL',
            'idModule' => 'int(11) NOT NULL',
            'idGroupe' => 'int(11) NOT NULL',
            'PRIMARY KEY (`idEnseignant`,`idGroupe`,`idModule`)',
                ), '');

           $this->createTable('enseignerSection', array(
            'idEnseignant' => 'int(11) NOT NULL',
            'idModule' => 'int(11) NOT NULL',
            'idSection' => 'int(11) NOT NULL',
            'idNiveau' => 'int(11) NOT NULL',
            'PRIMARY KEY (`idEnseignant`,`idNiveau`,`idSection`,`idModule`)',
                ), '');

           $this->createTable('groupe', array(
            'idGroupe' => 'pk',
            'numero' => 'int(5) NOT NULL',
            'idSection' => 'int(11) NOT NULL',
            'idNiveau' => 'int(11) NOT NULL',
                ), '');

            $this->addForeignKey(
            'fk-groupe-section_id',
            'groupe',
            'idNiveau,idSection',
            'section',
            'idNiveau,idSection',
            'CASCADE'
        );
         
             $this->createTable('etudiant', array(
            'idEtudiant' => 'pk',
            'matricule' => 'varchar(15) NOT NULL UNIQUE',
            'nom' => 'varchar(30) NOT NULL',
            'prenom' => 'varchar(30) NOT NULL',
            'dateNaissance' => 'date NOT NULL',
            'lieuNaissance' => 'varchar(15) NOT NULL',
            'dateAdmission' => 'date',
             'idGroupe' =>'int(11) NOT NULL ',
             'id'=> 'int(11) NOT NULL ',
                ), '');

            $this->addForeignKey(
            'fk-etudiant-user_id',
            'etudiant',
            'id',
            'user',
            'id',
            'CASCADE'
            );

            $this->addForeignKey(
            'fk-etudiant-groupe_id',
            'etudiant',
            'idGroupe',
            'groupe',
            'idGroupe',
            'CASCADE'
             );

        $this->createTable('module', array(
            'idModule' => 'pk',
            'designation' => 'varchar(30) ',
            'coefficient' =>'int(1) NOT NULL ',
            'credit' =>'int(10)  ',
            'bonus' => 'int(10)',
            'idUE' =>'int(11) NOT NULL ',
                ), ''
            );

          $this->addForeignKey(
            'fk-module-ue_id',
            'module',
            'idUE',
            'ue',
            'idUE',
            'CASCADE'
        );

         $this->createTable('note', array(
            'idNote' => 'pk',
            'valeur' => 'float(6) ',     
                ), '');


    }

    public function down()
    {
        echo "m140729_223509_initial does not support migration down.\n";
        return false;
    }

   
}
