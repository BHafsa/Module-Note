<?php

namespace app\modules\note\models;

use Yii;

/**
 * This is the model class for table "class_group".
 *
 * @property integer $class_group_id
 * @property integer $section_id
 * @property integer $level_id
 * @property string $date
 */
class ClassGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'class_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_id', 'level_id'], 'required'],
            [['section_id', 'level_id'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'class_group_id' => 'Class Group ID',
            'section_id' => 'Section ID',
            'level_id' => 'Level ID',
            'date' => 'Date',
        ];
    }
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::className(), ['section_id' => 'section_id', 'level_id' => 'level_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::className(), ['class_group_id' => 'class_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel()
    {
        return $this->hasOne(Level::className(), ['level_id' => 'level_id']);
    }
}
