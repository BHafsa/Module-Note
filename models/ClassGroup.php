<?php

namespace humhub\modules\note\models;

use Yii;

/**
 * This is the model class for table "class_group".
 *
 * @property integer $class_group_id
 * @property integer $number
 * @property integer $section_id
 * @property integer $level_id
 *
 * @property Section $section
 * @property Student[] $students
 * @property Level $level
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
            [['number', 'section_id', 'level_id'], 'required'],
            [['number', 'section_id', 'level_id'], 'integer'],
            [['section_id', 'level_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::className(), 'targetAttribute' => ['section_id' => 'section_id', 'level_id' => 'level_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'class_group_id' => Yii::t('NoteModule.note', 'Class Group ID'),
            'number' => Yii::t('NoteModule.note', 'Number'),
            'section_id' => Yii::t('NoteModule.note', 'Section ID'),
            'level_id' => Yii::t('NoteModule.note', 'Level ID'),
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
