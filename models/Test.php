<?php

namespace app\modules\note\models;

use Yii;

/**
 * This is the model class for table "test".
 *
 * @property integer $test_id
 * @property double $test_coef
 * @property string $test_label
 */
class Test extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['test_coef', 'test_label'], 'required'],
            [['test_coef'], 'number'],
            [['test_label'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'test_id' => 'Test ID',
            'test_coef' => 'Test Coef',
            'test_label' => 'Test Label',
        ];
    }
}
