<?php

namespace app\modules\note\models;

use Yii;

/**
 * This is the model class for table "option".
 *
 * @property integer $option_id
 * @property string $option_label
 */
class Option extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['option_label'], 'required'],
            [['option_label'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'option_id' => 'Option ID',
            'option_label' => 'Option Label',
        ];
    }
}
