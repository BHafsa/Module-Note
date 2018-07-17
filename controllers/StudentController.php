<?php

namespace humhub\modules\note\controllers;

use humhub\components\behaviors\AccessControl;
use humhub\components\Controller;
use humhub\modules\note\helpers\PdfHelper;
use humhub\modules\note\models\Student;
use humhub\modules\note\utils\FPDF\FPDF;
use  humhub\modules\note\permissions\ViewNote;
use yii\web\HttpException;

use Yii;
use yii\web\NotFoundHttpException;

class StudentController extends Controller
{

    public function behaviors()
    {
        return [
            'acl' => [
                'class' => AccessControl::className(),
               
            ]
        ];

    }


    public function actionIndex($schoolYear = null)
    {
        if(\Yii::$app->user->getPermissionManager()->can(new ViewNote())){
            if (!isset($schoolYear)) {
                $schoolYear = date('Y');
            }
            $student = $this->findStudent();
            return $this->render(
                'index',
                ['student' => $student, 'schoolYear' => $schoolYear]
            );
        }
        else{
            throw new HttpException(404, "Page non trouvée.");
        }
       
    }

    public function actionPrint($schoolYear = null)
    {
        if(\Yii::$app->user->getPermissionManager()->can(new ViewNote())){
            if (!isset($schoolYear)) {
                $schoolYear = date('Y');
            }
            $student = $this->findStudent();
            Yii::$app->response->headers->add('Content-Type', 'application/pdf');
            $pdf = PdfHelper::generateGradeReport($student, $schoolYear);
            $pdf->Output(date('U') . '_' . $student->user->username . '_' . $schoolYear . '.pdf', 'd');
        }
        else{
            throw new HttpException(404, "Page non trouvée.");
        }
       
    }

    private function findStudent()
    {
        $student = Student::findOne(['user_id' => Yii::$app->user->id]);
        if ($student == null) {
            throw new NotFoundHttpException();
        }
        return $student;
    }
}
