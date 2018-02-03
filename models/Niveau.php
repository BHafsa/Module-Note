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
        return 'niveau';
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
    return array('ues' => array(self::HAS_MANY, 'UE', 'idNiveau') );
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
