<?php

namespace app\modules\bulk_import\models;

use Yii;

/**
 * This is the model class for table "educational_unit".
 *
 * @property integer $educational_unit_id
 * @property string $code
 * @property integer $semester
 */
class EducationalUnit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'educational_unit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['semester'], 'integer'],
            [['code'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'educational_unit_id' => 'Educational Unit ID',
            'code' => 'Code',
            'semester' => 'Semester',
        ];
    }
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Course::className(), ['educational_unit_id' => 'educational_unit_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel()
    {
        return $this->hasOne(Level::className(), ['level_id' => 'level_id']);
    }
}
