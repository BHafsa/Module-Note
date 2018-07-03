<?php

namespace humhub\modules\note\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "course".
 *
 * @property integer $course_id
 * @property string $designation
 * @property integer $coefficient
 * @property integer $credit
 * @property integer $bonus
 * @property integer $educational_unit_id
 *
 * @property EducationalUnit $educationalUnit
 */
class Course extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['coefficient'], 'required'],
            [['coefficient', 'credit', 'bonus', 'educational_unit_id'], 'integer'],
            [['designation'], 'string', 'max' => 30],
            [['educational_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => EducationalUnit::className(), 'targetAttribute' => ['educational_unit_id' => 'educational_unit_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'course_id' => Yii::t('NoteModule.note', 'Course ID'),
            'designation' => Yii::t('NoteModule.note', 'Designation'),
            'coefficient' => Yii::t('NoteModule.note', 'Coefficient'),
            'credit' => Yii::t('NoteModule.note', 'Credit'),
            'bonus' => Yii::t('NoteModule.note', 'Bonus'),
            'educational_unit_id' => Yii::t('NoteModule.note', 'Educational Unit ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducationalUnit()
    {
        return $this->hasOne(EducationalUnit::className(), ['educational_unit_id' => 'educational_unit_id']);
    }
}
