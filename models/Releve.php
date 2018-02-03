<?php

namespace humhub\modules\Note\models;

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
        return 'releve';
    }

    public function relations()
    {
        return array('module' => array(self::BELONGS_TO, 'Module', 'idModule') );
        return array('etudiant' => array(self::BELONGS_TO, 'Etudiant', 'idEtidiant') );
        return array('note' => array(self::BELONGS_TO, 'Note', 'idNote') );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           
        ];
    }

      public function getData(){
    
    return array('0' => 'Madame', '1' => 'Mademoiselle','2'=>'Monsieur');
    }
   

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
           
        ];
    }
}
