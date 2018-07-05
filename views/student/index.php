<?php
/**
 * @var $this \humhub\components\View
 * @var $student \humhub\modules\note\models\Student
 * @var $schoolYear
 */
use yii\helpers\Html;
use yii\helpers\Url;

$this->setPageTitle(Yii::t('NoteModule.note', 'Grade Report'));
?>
<div id="layout-content" name="pdf">
    <div class="container">
        <div class="panel panel-default">

            <div class="panel-body">
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <?= Yii::t('NoteModule.note', 'School Year') ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <?php foreach ($student->schoolYears as $year) : ?>
                            <li><?php echo Html::a($year['date'], Url::toRoute(['/note/student', 'schoolYear' => $year['date']])) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                <h2 style="text-align:center;margin:20px;"><u><?=Yii::t('NoteModule.note', 'Grade Report') ?></u></h2>
                <div class="row">
                    <div class="col-md-4">
                        <p> <?= Yii::t('NoteModule.note', 'Registration Number') ?>
                            : <?= Html::encode("{$student->registration_number} ") ?> </p>
                        <p> <?= Yii::t('NoteModule.note', 'Last Name') ?>
                            :<?= Html::encode("{$student->last_name} ") ?> </p>
                        <p> <?= Yii::t('NoteModule.note', 'Admission Date') ?>
                            : <?= Html::encode("{$student->admission_date} ") ?> </p>
                        <p> <?= Yii::t('NoteModule.note', 'Preapared Diploma') ?>
                            : <?= Yii::t('NoteModule.note', 'State Engineer in computer science') ?></p>
                    </div>
                    <div class="col-md-4">
                        <p> <?= Yii::t('NoteModule.note', 'Level') ?>
                            : <?= Html::encode("{$student->year} ") ?><?= Html::encode("{$student->option} ") ?> </p>
                        <p> <?= Yii::t('NoteModule.note', 'First Name') ?>
                            : <?= Html::encode("{$student->first_name} ") ?> </p>
                    </div>
                    <div class="col-md-4">
                        <p> <?= Yii::t('NoteModule.note', 'Date Of Birth') ?>
                            : <?= Html::encode("{$student->date_of_birth} ") ?> </p>
                        <p> <?= Yii::t('NoteModule.note', 'at') ?>
                            : <?= Html::encode("{$student->place_of_birth} ") ?> </p>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-body">
                        <?= Html::a('<i class="fa fa-print" aria-hidden="true"></i>', Url::toRoute(['/note/student/print', 'schoolYear' => $schoolYear]), ['class' => 'btn btn-primary pull-right', 'target' => '_blank']) ?>
                        <table id="table"
                               class="table text-center table-hover table-mc-light-blue table-bordered table-striped"
                               align=center>
                            <thead style="text-align:center;">
                            <tr>
                                <th scope="col"><?= Yii::t('NoteModule.note', 'Semester') ?></th>
                                <th scope="col"><?= Yii::t('NoteModule.note', 'Nature') ?></th>
                                <th scope="col"><?= Yii::t('NoteModule.note', 'Code') ?></th>
                                <th scope="col"><?= Yii::t('NoteModule.note', 'Title (s)') ?></th>
                                <th scope="col"><?= Yii::t('NoteModule.note', 'Coefficient') ?></th>
                                <th scope="col"><?= Yii::t('NoteModule.note', 'Grade') ?></th>
                                <th scope="col"><?= Yii::t('NoteModule.note', 'Score') ?></th>
                                <th scope="col"><?= Yii::t('NoteModule.note', 'Session') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $S1 = 0;
                            $S2 = 0;
                            $b1 = 0;
                            $b2 = 0;
                            $courses = $student->getCourses($schoolYear);
                            foreach ($courses as $course) :
                                if ($course['semester'] == 0) {
                                    $S1 = $S1 + 1;
                                }
                                if ($course['semester'] == 1) {
                                    $S2 = $S2 + 1;
                                }
                            endforeach; ?>
                            <td data-title="<?= Yii::t('NoteModule.note', 'Semester') ?>" rowspan="<?php echo $S1; ?>">
                                S1
                            </td>
                            <?php foreach ($courses as $course) : ?>
                                <?php if ($course['semester'] == 0) { ?>
                                    <td data-title="<?= Yii::t('NoteModule.note', 'Nature') ?>"><?= Html::encode("{$course['nature']} ") ?> </td>
                                    <td data-title="<?= Yii::t('NoteModule.note', 'Code') ?>"><?= Html::encode("{$course['code']} ") ?>  </td>
                                    <td data-title="<?= Yii::t('NoteModule.note', 'Title (s)') ?>"><?= Html::encode("{$course['designation']} ") ?></td>
                                    <td data-title="<?= Yii::t('NoteModule.note', 'Coefficient') ?>"><?= Html::encode("{$course['coefficient']} ") ?></td>
                                    <td data-title="<?= Yii::t('NoteModule.note', 'Grade') ?>"><?= Html::encode("{$course['value']} ") ?>  </td>
                                    <?php
                                    if ($b1 == 0) {
                                        $b1 = 1; ?>
                                        <td data-title="<?= Yii::t('NoteModule.note', 'Score') ?>"
                                            rowspan="<?php echo $S1; ?>"><?= Html::encode("{$student->calculateSemesterScore($schoolYear,0)} ") ?>  </td>
                                        <td data-title="<?= Yii::t('NoteModule.note', 'Session') ?>"
                                            rowspan="<?php echo $S1; ?>"><?= Html::encode(Yii::t('NoteModule.note', 'February')) ?>  </td>
                                    <?php } ?>
                                <?php } ?>
                                </tr>
                            <?php endforeach; ?>

                            <tr>
                                <td data-title="<?= Yii::t('NoteModule.note', 'Semester') ?>"
                                    rowspan="<?php echo $S2 + 1; ?>">S2
                                </td>
                                <?php foreach ($courses as $course) : ?>
                                <?php if ($course['semester'] == 1) { ?>
                                    <td data-title="<?= Yii::t('NoteModule.note', 'Nature') ?>"><?= Html::encode("{$course['nature']} ") ?> </td>
                                    <td data-title="<?= Yii::t('NoteModule.note', 'Code') ?>"><?= Html::encode("{$course['code']} ") ?>  </td>
                                    <td data-title="<?= Yii::t('NoteModule.note', 'Title (s)') ?>"><?= Html::encode("{$course['designation']} ") ?></td>
                                    <td data-title="<?= Yii::t('NoteModule.note', 'Coefficient') ?>"><?= Html::encode("{$course['coefficient']} ") ?></td>
                                    <td data-title="<?= Yii::t('NoteModule.note', 'Grade') ?>"><?= Html::encode("{$course['value']} ") ?>  </td>
                                    <?php
                                    if ($b2 == 0) {
                                        $b2 = 1; ?>
                                        <td data-title="<?= Yii::t('NoteModule.note', 'Score') ?>"
                                            rowspan="<?php echo $S2 + 1; ?>"><?= Html::encode("{$student->calculateSemesterScore($schoolYear,1)} ") ?>  </td>
                                        <td data-title="<?= Yii::t('NoteModule.note', 'Session') ?>"
                                            rowspan="<?php echo $S2 + 1; ?>"><?= Html::encode(Yii::t('NoteModule.note', 'June')) ?>  </td>
                                    <?php } ?>
                                <?php } ?>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="panel-body">

                <div class="row">
                    <div class="col-md-4">
                        <p> <?= Yii::t('NoteModule.note', 'General Score') ?>
                            : <?= Html::encode("{$student->calculateGeneralScore($schoolYear)} ") ?> </p>
                        <p> <?= Yii::t('NoteModule.note', 'Decision') ?> : </p>
                    </div>
                    <div class="col-md-4">
                        <p> <?= Yii::t('NoteModule.note', 'Rank') ?>
                            : <?= Html::encode("{$student->getRank($schoolYear)}") ?>
                            / <?= Html::encode("{$student->getClassCount($schoolYear)}") ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>