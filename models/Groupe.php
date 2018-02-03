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
        return 'groupe';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           
        ];
    }

    public function relations()
    {
    return array('groupe' => array(self::BELONGS_TO, 'Section', 'idSection') );
    return array('etudiants' => array(self::HAS_MANY, 'Etudiant', 'idGroupe') );
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
