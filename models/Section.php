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
        return 'section';
    }

    public function relations()
    {
    return array('section' => array(self::BELONGS_TO, 'Niveau', 'idNiveau') );
    return array('groupes' => array(self::HAS_MANY, 'Groupe', 'idSection') );
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
