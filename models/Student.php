<?php

namespace humhub\modules\note\models;

use humhub\modules\user\models\User;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "student".
 *
 * @property integer $student_id
 * @property string $registration_number
 * @property string $last_name
 * @property string $first_name
 * @property string $date_of_birth
 * @property string $place_of_birth
 * @property string $admission_date
 * @property integer $class_group_id
 * @property integer $user_id
 *
 * @property ClassGroup $classGroup
 * @property User $user
 * @property array $schoolYears
 * @property string $year
 * @property string $option
 */
class Student extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['registration_number', 'last_name', 'first_name', 'date_of_birth', 'place_of_birth', 'class_group_id', 'user_id'], 'required'],
            [['date_of_birth', 'admission_date'], 'safe'],
            [['class_group_id', 'user_id'], 'integer'],
            [['registration_number', 'place_of_birth'], 'string', 'max' => 15],
            [['last_name', 'first_name'], 'string', 'max' => 30],
            [['registration_number'], 'unique'],
            [['class_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClassGroup::className(), 'targetAttribute' => ['class_group_id' => 'class_group_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'student_id' => Yii::t('NoteModule.note', 'Student ID'),
            'registration_number' => Yii::t('NoteModule.note', 'Registration Number'),
            'last_name' => Yii::t('NoteModule.note', 'Last Name'),
            'first_name' => Yii::t('NoteModule.note', 'First Name'),
            'date_of_birth' => Yii::t('NoteModule.note', 'Date Of Birth'),
            'place_of_birth' => Yii::t('NoteModule.note', 'Place Of Birth'),
            'admission_date' => Yii::t('NoteModule.note', 'Admission Date'),
            'class_group_id' => Yii::t('NoteModule.note', 'Class Group ID'),
            'user_id' => Yii::t('NoteModule.note', 'User ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassGroup()
    {
        return $this->hasOne(ClassGroup::className(), ['class_group_id' => 'class_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return array|ActiveRecord[]
     */
    public function getSchoolYears()
    {
        return GradeReport::find()->asArray()
            ->select(['date'])
            ->where(['student_id' => $this->student_id])
            ->groupBy('date')
            ->all();
    }

    public function getYear()
    {
        return $this->classGroup->level->year;
    }

    public function getOption()
    {
        return $this->classGroup->level->option;
    }

    /**
     * @param $schoolYear
     * @param string $semester
     * @return array
     */
    public function getCourses($schoolYear, $semester = '')
    {
        return $this->getCoursesQuery($schoolYear, $semester)->all();
    }


    public function calculateSemesterScore($schoolYear, $semester = '')
    {
        return round($this->getCoursesQuery($schoolYear, $semester)
            ->select('sum(value * coefficient) / sum(coefficient) as score')
            ->createCommand()->queryScalar(), 2);
    }

    public function calculateGeneralScore($schoolYear)
    {
        return round(($this->calculateSemesterScore($schoolYear, 0) + $this->calculateSemesterScore($schoolYear, 1)) / 2, 2);
    }

    /**
     * @param $schoolYear
     * @return array|Student[]
     */
    public function getClassStudents($schoolYear)
    {
        return $this->getClassQuery($schoolYear)->all();
    }

    public function getRank($schoolYear)
    {
        $classStudents = $this->getClassStudents($schoolYear);
        $generalScore = $this->calculateGeneralScore($schoolYear);
        $rank = 1;
        foreach ($classStudents as $student) {
            if ($student->calculateGeneralScore($schoolYear) > $generalScore) {
                $rank++;
            }
        }
        return $rank;
    }

    public function getClassCount($schoolYear)
    {
        return self::find()->select('count(*)')
            ->from('(' . $this->getClassQuery($schoolYear)->createCommand()->sql . ') x')
            ->createCommand()->queryScalar();
    }

    /**
     * @param $schoolYear
     * @param string $semester
     * @return \yii\db\ActiveQuery
     */
    private function getCoursesQuery($schoolYear, $semester = '')
    {
        return EducationalUnit::find()
            ->select(['nature', 'code', 'semester', 'designation', 'coefficient', 'value'])
            ->asArray()
            ->join(
                'JOIN',
                Course::tableName(),
                EducationalUnit::tableName() . '.educational_unit_id=' . Course::tableName() . '.educational_unit_id'
            )->join(
                'JOIN',
                GradeReport::tableName(),
                ['AND',
                    GradeReport::tableName() . '.student_id=' . $this->student_id,
                    GradeReport::tableName() . '.course_id=' . Course::tableName() . '.course_id',
                    GradeReport::tableName() . '.date=' . $schoolYear
                ]
            )->join(
                'JOIN',
                Grade::tableName(),
                GradeReport::tableName() . '.grade_id=' . Grade::tableName() . '.grade_id'
            )->andFilterWhere(['semester' => $semester]);
    }


    private function getClassQuery($schoolYear)
    {
        return Student::find()
            ->join(
                'JOIN',
                ClassGroup::tableName(),
                Student::tableName() . '.class_group_id=' . ClassGroup::tableName() . '.class_group_id'
            )->join(
                'JOIN',
                Level::tableName(),
                [
                    'AND',
                    Level::tableName() . '.level_id=' . ClassGroup::tableName() . '.level_id',
                    Level::tableName() . '.year=' . "'" . $this->year . "'",
                ]
            )->join(
                'JOIN',
                GradeReport::tableName(),
                ['AND',
                    GradeReport::tableName() . '.student_id=' . Student::tableName() . '.student_id',
                    GradeReport::tableName() . '.date=' . $schoolYear,
                ]
            )->groupBy(Student::tableName() . '.student_id');
    }

}
