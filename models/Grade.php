<?php

namespace humhub\modules\note\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "grade".
 *
 * @property integer $grade_id
 * @property double $value
 */
class Grade extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'grade_id' => Yii::t('NoteModule.note', 'Grade ID'),
            'value' => Yii::t('NoteModule.note', 'Value'),
        ];
    }
}
