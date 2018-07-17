<?php

namespace humhub\modules\note\models;

use Yii;

/**
 * This is the model class for table "moral_person".
 *
 * @property integer $moral_person_id
 * @property integer $user_id
 */
class MoralPerson extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'moral_person';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'moral_person_id' => 'Moral Person ID',
            'user_id' => 'User ID',
        ];
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
