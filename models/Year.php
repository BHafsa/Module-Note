<?php

namespace humhub\modules\note\models;

use Yii;

/**
 * This is the model class for table "year".
 *
 * @property integer $year_id
 * @property string $year_label
 */
class Year extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'year';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year_label'], 'required'],
            [['year_label'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'year_id' => 'Year ID',
            'year_label' => 'Year Label',
        ];
    }
}
