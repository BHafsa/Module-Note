<?php

namespace app\modules\bulk_import\models;

use Yii;

/**
 * This is the model class for table "instructor".
 *
 * @property integer $instructor_id
 * @property string $registration_number
 * @property integer $user_id
 */
class Instructor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instructor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['registration_number', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['registration_number'], 'string', 'max' => 15],
            [['registration_number'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'instructor_id' => 'Instructor ID',
            'registration_number' => 'Registration Number',
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
