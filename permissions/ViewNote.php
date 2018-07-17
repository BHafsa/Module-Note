<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */
namespace humhub\modules\note\permissions;

use humhub\modules\user\models\User;
use humhub\modules\note\models\Student;

use Yii;
/**
 * Send Mail Permission
 */
class ViewNote extends \humhub\libs\BasePermission
{   
    /**
     * @inheritdoc
     */

    public function getDefaultState($groupId)
    {
        return Student::find()
                      ->where(['user_id'=>\Yii::$app->user->id])
                      ->exists();
        // return true;
                }
    
    /**
     * @inheritdoc
     */
    protected $title = "View Note";
    /**
     * @inheritdoc
     */
    protected $description = "Allows the student to see their notes";
    /**
     * @inheritdoc
     */
    protected $moduleId = 'GradeManagement';
    /**
     * @inheritdoc
     */
    protected $id = 'ViewNote';


}