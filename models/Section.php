<?php

namespace humhub\modules\note\models;

use Yii;

/**
 * This is the model class for table "section".
 *
 * @property integer $section_id
 * @property integer $level_id
 * @property string $section_name
 */
class Section extends \yii\db\ActiveRecord
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
            'section_id' => 'Section ID',
            'level_id' => 'Level ID',
            'section_name' => 'Section Name',
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
