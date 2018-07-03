<?php

namespace humhub\modules\note\models;

use Yii;

/**
 * This is the model class for table "grade_report".
 *
 * @property integer $student_id
 * @property integer $course_id
 * @property integer $grade_id
 * @property string $date
 */
class GradeReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grade_report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'course_id', 'grade_id', 'date'], 'required'],
            [['student_id', 'course_id', 'grade_id'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'student_id' => Yii::t('NoteModule.note', 'Student ID'),
            'course_id' => Yii::t('NoteModule.note', 'Course ID'),
            'grade_id' => Yii::t('NoteModule.note', 'Grade ID'),
            'date' => Yii::t('NoteModule.note', 'Date'),
        ];
    }
}
