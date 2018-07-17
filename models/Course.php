<?php

namespace app\modules\note\models;

use Yii;

/**
 * This is the model class for table "course".
 *
 * @property integer $course_id
 * @property string $designation
 * @property integer $coefficient
 * @property integer $credit
 * @property integer $bonus
 * @property integer $educational_unit_id
 */
class Course extends \yii\db\ActiveRecord
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
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'course_id' => 'Course ID',
            'designation' => 'Designation',
            'coefficient' => 'Coefficient',
            'credit' => 'Credit',
            'bonus' => 'Bonus',
            'educational_unit_id' => 'Educational Unit ID',
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
