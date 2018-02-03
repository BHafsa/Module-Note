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
        return 'ue';
    }

    public function relations()
    {
        return array('ue' => array(self::BELONGS_TO, 'Niveau', 'idNiveau') );
        return array('modules' => array(self::HAS_MANY, 'Module', 'idUE') );
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
        return [
           
        ];
    }
}
