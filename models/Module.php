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
        return 'module';
    }

    public function relations()
    {
        
        return array('module' => array(self::BELONGS_TO, 'UE', 'idUE') );
        return array('releves' => array(self::HAS_MANY, 'Releve', 'idModule') );
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           
        ];
    }

   

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
       
    }
}
