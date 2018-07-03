<?php

namespace humhub\modules\note\commands;

use Exception;
use humhub\modules\note\models\ClassGroup;
use humhub\modules\note\models\Course;
use humhub\modules\note\models\EducationalUnit;
use humhub\modules\note\models\Grade;
use humhub\modules\note\models\GradeReport;
use humhub\modules\note\models\Instructor;
use humhub\modules\note\models\Level;
use humhub\modules\note\models\Section;
use humhub\modules\note\models\Student;
use humhub\modules\user\models\Password;
use humhub\modules\user\models\User;
use yii\console\Controller;

class NoteController extends Controller
{

    public $users = [
        [
            'username' => 'ens_zitouni',
            'email' => 'a_zitouni@school.dz',
            'title' => 'Instructor',
            'firstname' => 'Abbes',
            'lastname' => 'ZITOUNI',
            'registration_number' => 'ENS_ZITOUNI',

        ],
        [
            'username' => 'ens_yousfi',
            'email' => 'h_yousfi@school.dz',
            'title' => 'Instructor',
            'firstname' => 'Hanane',
            'lastname' => 'YOUSFI',
            'registration_number' => 'ENS_YOUSFI',

        ],
        [
            'username' => 'st_seridi',
            'email' => 'am_seridi@school.dz',
            'title' => 'Student',
            'firstname' => 'Mehdi',
            'lastname' => 'SERIDI',
            'date_of_birth' => '1996-12-16',
            'place_of_birth' => 'Chettia',
            'admission_date' => '2014-9-14',
            'registration_number' => 'ST_SERIDI',

        ],
        [
            'username' => 'st_sidali',
            'email' => 'ak_zitouni@school.dz',
            'title' => 'Student',
            'firstname' => 'Kenza',
            'lastname' => 'SIDALI',
            'date_of_birth' => '1997-9-11',
            'place_of_birth' => 'Kouba',
            'admission_date' => '2014-9-14',
            'registration_number' => 'ST_SIDALI',

        ],
    ];
    public $defaultPassowrd = 'hafsa';
    public $instructorOneUserId = -1;
    public $instructorTwoUserId = -1;
    public $studentOneUserId = -1;
    public $studentTwoUserId = -1;
    public $levels = [
        ['year' => '1CPI', 'option' => null,],
        ['year' => '2CPI', 'option' => null,],
        ['year' => '1CS', 'option' => null],
        ['year' => '2CS', 'option' => 'SIQ',],
        ['year' => '2CS', 'option' => 'SIT',],
        ['year' => '2CS', 'option' => 'SIL',],
    ];
    public $educationalUnits = [
        ['code' => 'UEF1.1.1', 'nature' => 'UE Fondamentale', 'semester' => 0,
            'courses' => [
                ['designation' => 'SYST1', 'coefficient' => 5, 'credit' => null, 'bonus' => 60,
                    'note' => ['value' => 13, 'date' => '2016'],
                ],
                ['designation' => 'RES1', 'coefficient' => 4, 'credit' => null, 'bonus' => 60,
                    'note' => ['value' => 11, 'date' => '2016'],
                ],
            ]
        ],
        ['code' => 'UEF1.1.2', 'nature' => 'UE Fondamentale', 'semester' => 0,
            'courses' => [
                ['designation' => 'IGL', 'coefficient' => 5, 'credit' => null, 'bonus' => 60,
                    'note' => ['value' => 13, 'date' => '2016'],
                ],
                ['designation' => 'THP', 'coefficient' => 4, 'credit' => null, 'bonus' => 60,
                    'note' => ['value' => 10, 'date' => '2016'],
                ],
            ]
        ],
        ['code' => 'UEM1.1', 'nature' => 'UE Méthodologie', 'semester' => 0,
            'courses' => [
                ['designation' => 'ANUM', 'coefficient' => 4, 'credit' => null, 'bonus' => 60,
                    'note' => ['value' => 12, 'date' => '2016'],
                ],
                ['designation' => 'RO', 'coefficient' => 3, 'credit' => null, 'bonus' => 60,
                    'note' => ['value' => 13, 'date' => '2016'],
                ],
                ['designation' => 'ORG', 'coefficient' => 3, 'credit' => null, 'bonus' => 60,
                    'note' => ['value' => 16, 'date' => '2016'],
                ],
            ]
        ],
        ['code' => 'UET1.1', 'nature' => 'UE Transversale', 'semester' => 0,
            'courses' => [
                ['designation' => 'ANG1', 'coefficient' => 2, 'credit' => null, 'bonus' => 60,
                    'note' => ['value' => 11, 'date' => '2016'],
                ],
            ]
        ],
        ['code' => 'UEF1.2.1', 'nature' => 'UE Fondamentale', 'semester' => 1,
            'courses' => [
                ['designation' => 'SYST2', 'coefficient' => 4, 'credit' => null, 'bonus' => 60,
                    'note' => ['value' => 11, 'date' => '2016'],
                ],
                ['designation' => 'RES2', 'coefficient' => 3, 'credit' => null, 'bonus' => 60,
                    'note' => ['value' => 13, 'date' => '2016'],
                ],
                ['designation' => 'ARCH', 'coefficient' => 4, 'credit' => null, 'bonus' => 60,
                    'note' => ['value' => 12, 'date' => '2016'],
                ],
            ]
        ],
        ['code' => 'UEF1.2.2', 'nature' => 'UE Fondamentale', 'semester' => 1,
            'courses' => [
                ['designation' => 'MCSI', 'coefficient' => 5, 'credit' => null, 'bonus' => 60,
                    'note' => ['value' => 13, 'date' => '2016'],
                ],
                ['designation' => 'BDD', 'coefficient' => 5, 'credit' => null, 'bonus' => 60,
                    'note' => ['value' => 13, 'date' => '2016'],
                ],
            ]],
        ['code' => 'UEM1.2', 'nature' => 'UE Méthodologie', 'semester' => 1,
            'courses' => [
                ['designation' => 'SEC', 'coefficient' => 1, 'credit' => null, 'bonus' => 60,
                    'note' => ['value' => 16, 'date' => '2016'],
                ],
                ['designation' => 'CPROJ', 'coefficient' => 3, 'credit' => null, 'bonus' => 60,
                    'note' => ['value' => 12, 'date' => '2016'],
                ],
            ]
        ],
        ['code' => 'UET1.2', 'nature' => 'UE Transversale', 'semester' => 1,
            'courses' => [
                ['designation' => 'ANG', 'coefficient' => 2, 'credit' => null, 'bonus' => 60,
                    'note' => ['value' => 13, 'date' => '2016'],
                ],
            ]
        ],
    ];

    public $sections = [
        [
            'section_name' => 'A',
            'groups' => [['number' => 1], ['number' => 2], ['number' => 3],]
        ],
        [
            'section_name' => 'B',
            'groups' => [['number' => 4], ['number' => 5], ['number' => 6],]
        ],
        [
            'section_name' => 'C',
            'groups' => [['number' => 7], ['number' => 8], ['number' => 9],]
        ],
    ];


    public function actionAddDemoData()
    {
        echo "Creating Demo data \n";
        $this->instructorOneUserId = $this->createNewUser(0);
        $this->instructorTwoUserId = $this->createNewUser(1);
        $this->studentOneUserId = $this->createNewUser(2);
        $this->studentTwoUserId = $this->createNewUser(3);

        $instOne = $this->createInstructor(0, $this->instructorOneUserId);
        echo 'Created Instructor ' . $instOne->first_name . ' ' . $instOne->last_name . "\n";
        $instTwo = $this->createInstructor(1, $this->instructorTwoUserId);
        echo 'Created Instructor ' . $instTwo->first_name . ' ' . $instTwo->last_name . "\n";

        $levelId = 1;
        foreach ($this->levels as $level) {
            $levelModel = new Level();
            $levelModel->year = $level['year'];
            $levelModel->option = $level['option'];
            $levelModel->save();
            if ($level['year'] == '1CS') {
                $levelId = $levelModel->level_id;
            }
        }
        echo 'Done Creating Levels , created ' . count($this->levels) . " levels\n";

        foreach ($this->educationalUnits as $educationalUnit) {
            $educationalUnitModel = new EducationalUnit();
            $educationalUnitModel->code = $educationalUnit['code'];
            $educationalUnitModel->nature = $educationalUnit['nature'];
            $educationalUnitModel->semester = $educationalUnit['semester'];
            $educationalUnitModel->level_id = $levelId;
            $educationalUnitModel->save();
            foreach ($educationalUnit['courses'] as $course) {
                $courseModel = new Course();
                $courseModel->designation = $course['designation'];
                $courseModel->coefficient = $course['coefficient'];
                $courseModel->credit = $course['credit'];
                $courseModel->bonus = $course['bonus'];
                $courseModel->educational_unit_id = $educationalUnitModel->educational_unit_id;
                $grade = new Grade();
                $grade->value = $course['note']['value'];
                $grade->save();
                $gradeReport = new GradeReport();
                $gradeReport->course_id = $courseModel->course_id;
                $gradeReport->grade_id = $grade->grade_id;
                $gradeReport->student_id = $this->studentOneUserId;
                $gradeReport->date = $course['note']['date'];
                $gradeReport->save();
            }
        }
        echo 'Done Creating Educational Units , created ' . count($this->educationalUnits) . " EUs\n";

        $firstGroupId = -1;
        foreach ($this->sections as $section) {
            $sectionModel = new Section();
            $sectionModel->section_name = $section['section_name'];
            $sectionModel->level_id = $levelId;
            $sectionModel->save();
            foreach ($section['groups'] as $group) {
                $classGroup = new ClassGroup();
                $classGroup->number = $group['number'];
                $classGroup->section_id = $sectionModel->section_id;
                $classGroup->level_id = $levelId;
                $classGroup->save();
                if ($firstGroupId == -1) {
                    $firstGroupId = $classGroup->class_group_id;
                }
            }
        }
        echo 'Done Creating Sections , created ' . count($this->sections) . " Sections\n";

        $stOne = $this->createStudent(2, $this->studentOneUserId, $firstGroupId);
        echo 'Created Student ' . $stOne->first_name . ' ' . $stOne->last_name . "\n";
        $stTwo = $this->createStudent(3, $this->studentTwoUserId, $firstGroupId + 1);
        echo 'Created Student ' . $stTwo->first_name . ' ' . $stTwo->last_name . "\n";
    }


    private function createNewUser($userNum)
    {
        $user = new User();
//        $user->group_id = 1;
        $user->username = $this->users[$userNum]['username'];
        $user->email = $this->users[$userNum]['email'];
        $user->status = User::STATUS_ENABLED;
        $user->language = '';
        if (!$user->save()) {
            var_dump($user->errors);
            throw new Exception('Could not save user');
        }

        $user->profile->title = $this->users[$userNum]['title'];
        $user->profile->firstname = $this->users[$userNum]['firstname'];
        $user->profile->lastname = $this->users[$userNum]['lastname'];
        $user->profile->save();

        $password = new Password();
        $password->user_id = $user->id;
        $password->setPassword($this->defaultPassowrd);
        $password->save();

        return $user->id;
    }

    private function createInstructor($instNum, $userId)
    {
        $instructor = new Instructor();
        $instructor->first_name = $this->users[$instNum]['firstname'];
        $instructor->last_name = $this->users[$instNum]['lastname'];
        $instructor->registration_number = $this->users[$instNum]['registration_number'];
        $instructor->user_id = $userId;
        $instructor->save();
        return $instructor;
    }

    private function createStudent($stNum, $userId, $groupId)
    {
        $student = new Student();
        $student->first_name = $this->users[$stNum]['firstname'];
        $student->last_name = $this->users[$stNum]['lastname'];
        $student->registration_number = $this->users[$stNum]['registration_number'];
        $student->date_of_birth = $this->users[$stNum]['date_of_birth'];
        $student->place_of_birth = $this->users[$stNum]['place_of_birth'];
        $student->admission_date = $this->users[$stNum]['admission_date'];
        $student->class_group_id = $groupId;
        $student->user_id = $userId;
        return $student;
    }
}
