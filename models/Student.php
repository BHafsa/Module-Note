<?php

namespace humhub\modules\note\models;

use humhub\modules\user\models\User;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "student".
 *
 * @property integer $student_id
 * @property string $registration_number
 * @property string $last_name
 * @property string $first_name
 * @property string $date_of_birth
 * @property string $place_of_birth
 * @property string $admission_date
 * @property integer $class_group_id
 * @property integer $user_id
 *
 * @property ClassGroup $classGroup
 * @property User $user
 */
class Student extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['registration_number', 'last_name', 'first_name', 'date_of_birth', 'place_of_birth', 'class_group_id', 'user_id'], 'required'],
            [['date_of_birth', 'admission_date'], 'safe'],
            [['class_group_id', 'user_id'], 'integer'],
            [['registration_number', 'place_of_birth'], 'string', 'max' => 15],
            [['last_name', 'first_name'], 'string', 'max' => 30],
            [['registration_number'], 'unique'],
            [['class_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClassGroup::className(), 'targetAttribute' => ['class_group_id' => 'class_group_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'student_id' => Yii::t('NoteModule.note', 'Student ID'),
            'registration_number' => Yii::t('NoteModule.note', 'Registration Number'),
            'last_name' => Yii::t('NoteModule.note', 'Last Name'),
            'first_name' => Yii::t('NoteModule.note', 'First Name'),
            'date_of_birth' => Yii::t('NoteModule.note', 'Date Of Birth'),
            'place_of_birth' => Yii::t('NoteModule.note', 'Place Of Birth'),
            'admission_date' => Yii::t('NoteModule.note', 'Admission Date'),
            'class_group_id' => Yii::t('NoteModule.note', 'Class Group ID'),
            'user_id' => Yii::t('NoteModule.note', 'User ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassGroup()
    {
        return $this->hasOne(ClassGroup::className(), ['class_group_id' => 'class_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
