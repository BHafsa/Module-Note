<?php

namespace humhub\modules\note\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "educational_unit".
 *
 * @property integer $educational_unit_id
 * @property string $code
 * @property string $nature
 * @property integer $semester
 * @property integer $level_id
 *
 * @property Level $level
 */
class EducationalUnit extends ActiveRecord
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
            [['code', 'nature', 'level_id'], 'required'],
            [['semester', 'level_id'], 'integer'],
            [['code', 'nature'], 'string', 'max' => 30],
            [['level_id'], 'exist', 'skipOnError' => true, 'targetClass' => Level::className(), 'targetAttribute' => ['level_id' => 'level_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'educational_unit_id' => Yii::t('NoteModule.note', 'Educational Unit ID'),
            'code' => Yii::t('NoteModule.note', 'Code'),
            'nature' => Yii::t('NoteModule.note', 'Nature'),
            'semester' => Yii::t('NoteModule.note', 'Semester'),
            'level_id' => Yii::t('NoteModule.note', 'Level ID'),
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
