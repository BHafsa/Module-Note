<?php

namespace humhub\modules\note\models;

use Yii;

/**
 * This is the model class for table "etudiant".
 *
 * @property string $matricule
 */
class Etudiant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'etudiant';
    }

    public function relations()
    {
        return array('etudiant' => array(self::BELONGS_TO, 'Groupe', 'idGroupe') );
        return array('releves' => array(self::HAS_MANY, 'Releve', 'idModule') );
       
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['matricule'], 'string', 'max' => 20],
         [['idGroupe'], 'int', 'max' => 11],
        ];
    }

 

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'matricule' => 'Matricule',
        ];
    }
}
