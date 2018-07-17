<?php

namespace app\modules\bulk_import\models;

use Yii;

/**
 * This is the model class for table "level".
 *
 * @property integer $level_id
 * @property integer $year_id
 * @property integer $option_id
 */
class Level extends \yii\db\ActiveRecord
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
            [['year_id'], 'required'],
            [['year_id', 'option_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'level_id' => 'Level ID',
            'year_id' => 'Year ID',
            'option_id' => 'Option ID',
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
