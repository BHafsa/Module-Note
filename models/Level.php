<?php

namespace humhub\modules\note\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "level".
 *
 * @property integer $level_id
 * @property string $year
 * @property string $option
 *
 * @property EducationalUnit[] $educationalUnits
 */
class Level extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year'], 'required'],
            [['year'], 'string', 'max' => 10],
            [['option'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'level_id' => Yii::t('NoteModule.note', 'Level ID'),
            'year' => Yii::t('NoteModule.note', 'Year'),
            'option' => Yii::t('NoteModule.note', 'Option'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducationalUnits()
    {
        return $this->hasMany(EducationalUnit::className(), ['level_id' => 'level_id']);
    }
}
