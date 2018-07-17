<?php

namespace app\modules\note\models;

use Yii;

/**
 * This is the model class for table "grade".
 *
 * @property integer $student_id
 * @property integer $instructor_id
 * @property integer $course_id
 * @property integer $test_id
 * @property double $value
 * @property string $date
 */
class Grade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'instructor_id', 'course_id', 'test_id', 'value', 'date'], 'required'],
            [['student_id', 'instructor_id', 'course_id', 'test_id'], 'integer'],
            [['value'], 'number'],
            [['date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'student_id' => 'Student ID',
            'instructor_id' => 'Instructor ID',
            'course_id' => 'Course ID',
            'test_id' => 'Test ID',
            'value' => 'Value',
            'date' => 'Date',
        ];
    }
}
