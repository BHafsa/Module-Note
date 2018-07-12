<?php

namespace humhub\modules\note\helpers;

use humhub\modules\note\models\Student;
use humhub\modules\note\utils\FPDF\FPDF;
use Yii;

class PdfHelper
{
    /**
     * @param $student Student
     * @param $schoolYear
     * @return FPDF
     */
    public static function generateGradeReport($student, $schoolYear)
    {
        $pdf = new FPDF();
        self::setUpPage($pdf);
        self::setPageTitle($pdf, Yii::t('NoteModule.note', 'Grade Report'));
        self::writeStudentInfo($pdf, $student);
        self::writeScoreTableHeaders($pdf);
        $position = 78;
        $position = self::writeGradeTable($pdf, $student, $schoolYear, $position);
        self::writeGeneralScore($pdf, $student, $schoolYear, $position);
        return $pdf;
    }

    /**
     * @param $pdf FPDF
     */
    protected static function setUpPage($pdf)
    {
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 30);
    }

    /**
     * @param $pdf FPDF
     * @param $title
     */
    protected static function setPageTitle($pdf, $title)
    {
        $pdf->SetY(8);
        $pdf->SetX(64);
        $pdf->Cell(40, 10, utf8_decode($title));
        $pdf->Ln();
        $pdf->Ln();
    }

    /**
     * @param $pdf FPDF
     * @param $student Student
     */
    private static function writeStudentInfo($pdf, $student)
    {
        $pdf->SetX(8);
        $pdf->SetFontSize(10);
        $pdf->Cell(40, 10, Yii::t('NoteModule.note', 'Registration Number') . ' : ' . $student->registration_number);
        $pdf->SetX(66);
        $pdf->Cell(40, 10, utf8_decode(Yii::t('NoteModule.note', 'Level') . ' : ' . $student->year));
        $pdf->SetX(120);
        $pdf->Cell(40, 10, Yii::t('NoteModule.note', 'Date Of Birth') . ' : ' . $student->date_of_birth);
        $pdf->Ln();
        $pdf->SetX(8);
        $pdf->Cell(40, 10, Yii::t('NoteModule.note', 'Last Name') . ' : ' . $student->last_name);
        $pdf->SetX(66);
        $pdf->Cell(40, 10, Yii::t('NoteModule.note', 'First Name') . ' : ' . $student->first_name);
        $pdf->SetX(126);
        $pdf->Cell(40, 10, utf8_decode(Yii::t('NoteModule.note', 'At') . ' : ' . $student->place_of_birth));
        $pdf->Ln();
        $pdf->SetX(8);
        $pdf->Cell(40, 10, Yii::t('NoteModule.note', 'Admission Date') . ' : ' . $student->admission_date);
        $pdf->Ln();
        $pdf->SetX(8);
    }

    /**
     * @param $pdf FPDF
     */
    private static function writeScoreTableHeaders($pdf)
    {
        $pdf->SetDrawColor(183);
        $pdf->SetFillColor(221);
        $pdf->SetTextColor(0);
        $pdf->SetY(70);

        $pdf->SetX(8);
        $pdf->Cell(20, 8, Yii::t('NoteModule.note', 'Semester'), 1, 0, 'C', 1);

        $pdf->SetX(28); // 8 + 72
        $pdf->Cell(40, 8, Yii::t('NoteModule.note', 'Nature'), 1, 0, 'C', 1);

        $pdf->SetX(68); // 80+10
        $pdf->Cell(20, 8, Yii::t('NoteModule.note', 'Code'), 1, 0, 'C', 1);

        $pdf->SetX(88); // 104 + 20
        $pdf->Cell(20, 8, Yii::t('NoteModule.note', 'Course'), 1, 0, 'C', 1);

        $pdf->SetX(108); // 104 + 20
        $pdf->Cell(20, 8, Yii::t('NoteModule.note', 'Coefficient'), 1, 0, 'C', 1);

        $pdf->SetX(128); // 104 + 20
        $pdf->Cell(20, 8, Yii::t('NoteModule.note', 'Grade'), 1, 0, 'C', 1);

        $pdf->SetX(148); // 104 + 20
        $pdf->Cell(20, 8, Yii::t('NoteModule.note', 'Score'), 1, 0, 'C', 1);

        $pdf->SetX(168); // 104 + 20
        $pdf->Cell(20, 8, Yii::t('NoteModule.note', 'Session'), 1, 0, 'C', 1);
        $pdf->Ln();
    }

    /**
     * @param $pdf FPDF
     * @param $student Student
     * @param $schoolYear
     * @param $position
     * @return mixed
     */
    private static function writeGradeTable($pdf, $student, $schoolYear, $position)
    {
        $courses = $student->getCourses($schoolYear);
        $S1 = 0;
        $S2 = 0;
        foreach ($courses as $course):
            if ($course['semester'] == 0) {
                $S1 = $S1 + 1;
            }
            if ($course['semester'] == 1) {
                $S2 = $S2 + 1;
            }
        endforeach;

        $pdf->SetY($position);
        $pdf->SetX(8);
        $pdf->MultiCell(20, 8 * $S1, '1', 1, 'C');
        $pdf->SetY($position + 8 * $S1);
        $pdf->SetX(8);
        $pdf->MultiCell(20, 8 * $S2, '2', 1, 'C');

        $pdf->SetY($position);
        $pdf->SetX(148);
        $semester1Score = $student->calculateSemesterScore($schoolYear, 0);
        $pdf->MultiCell(20, 8 * $S1, $semester1Score, 1, 'C');
        $pdf->SetY($position + 8 * $S1);
        $pdf->SetX(148);
        $semester2Score = $student->calculateSemesterScore($schoolYear, 2);
        $pdf->MultiCell(20, 8 * $S2, $semester2Score, 1, 'C');

        $pdf->SetY($position);
        $pdf->SetX(168);
        $pdf->MultiCell(20, 8 * $S1, utf8_decode(Yii::t('NoteModule.note', 'February')), 1, 'C');
        $pdf->SetY($position + 8 * $S1);
        $pdf->SetX(168);
        $pdf->MultiCell(20, 8 * $S2, Yii::t('NoteModule.note', 'June'), 1, 'C');


        //tableau de note
        foreach ($courses as $course) :
            $pdf->SetY($position);
            $pdf->SetX(28);
            $pdf->MultiCell(40, 8, utf8_decode($course['nature']), 1, 'C');
            $pdf->SetY($position);
            $pdf->SetX(68);
            $pdf->MultiCell(20, 8, $course['code'], 1, 'R');
            $pdf->SetY($position);
            $pdf->SetX(88);
            $pdf->MultiCell(20, 8, $course['designation'], 1, 'R');
            $pdf->SetY($position);
            $pdf->SetX(108);
            $pdf->MultiCell(20, 8, $course['coefficient'], 1, 'R');
            $pdf->SetY($position);
            $pdf->SetX(128);
            $pdf->MultiCell(20, 8, $course['value'], 1, 'R');
            $position = $position + 8;
        endforeach;
        return $position;
    }

    /**
     * @param $pdf FPDF
     * @param $student Student
     * @param $schoolYear
     * @param $position
     */
    private static function writeGeneralScore($pdf, $student, $schoolYear, $position)
    {
        $pdf->SetY($position + 8);
        $pdf->SetX(8);
        $pdf->Cell($position + 8, 10, Yii::t('NoteModule.note', 'General Score') . ' : ' . $student->calculateGeneralScore($schoolYear));
        $pdf->Ln();
        $pdf->SetX(8);
        $pdf->Cell(40, 10, Yii::t('NoteModule.note', 'Decision') . ' : ');
        $pdf->SetX(66);
        $pdf->Cell(40, 10, Yii::t('NoteModule.note', 'Rank') . ' : ' . $student->getRank($schoolYear) . '/' . $student->getClassCount($schoolYear));
    }
}
