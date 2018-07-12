<?php

namespace humhub\modules\note\models;

use humhub\modules\user\models\User;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "instructor".
 *
 * @property integer $instructor_id
 * @property string $last_name
 * @property string $first_name
 * @property string $registration_number
 * @property integer $user_id
 *
 * @property User $user
 */
class Instructor extends ActiveRecord
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
            [['last_name', 'first_name', 'registration_number', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['last_name', 'first_name'], 'string', 'max' => 30],
            [['registration_number'], 'string', 'max' => 15],
            [['registration_number'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'instructor_id' => Yii::t('NoteModule.note', 'Instructor ID'),
            'last_name' => Yii::t('NoteModule.note', 'Last Name'),
            'first_name' => Yii::t('NoteModule.note', 'First Name'),
            'registration_number' => Yii::t('NoteModule.note', 'Registration Number'),
            'user_id' => Yii::t('NoteModule.note', 'User ID'),
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
