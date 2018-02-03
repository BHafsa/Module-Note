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
        return 'note';
    }

    public function relations()
    {
        return array('releves' => array(self::HAS_MANY, 'Releve', 'idNote') );
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
            
    }
}
