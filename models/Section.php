<?php

namespace humhub\modules\note\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "section".
 *
 * @property integer $section_id
 * @property integer $level_id
 * @property string $section_name
 *
 * @property ClassGroup[] $classGroups
 */
class Section extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_id', 'level_id', 'section_name'], 'required'],
            [['section_id', 'level_id'], 'integer'],
            [['section_name'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'section_id' => Yii::t('NoteModule.note', 'Section ID'),
            'level_id' => Yii::t('NoteModule.note', 'Level ID'),
            'section_name' => Yii::t('NoteModule.note', 'Section Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassGroups()
    {
        return $this->hasMany(ClassGroup::className(), ['section_id' => 'section_id', 'level_id' => 'level_id']);
    }
}
