
<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use humhub\modules\Note\models\Releve;

?>
<div id="layout-content" name="pdf">
<div class="container">
<div class="panel panel-default">
 
 <div class="panel-body" >
  
  <div class="dropdown">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
  Année d'étude
    <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
           <?php foreach ($anneeEtudeTab as $anneE): ?>
            <li><?php echo Html::a($anneE['date'], Url::toRoute(["/Note/etudiant",'anneeEtud' => $anneE['date']])) ?></li>
           
       
       <?php endforeach; ?>
</ul>
</div>
    </div>

    <div class="panel-body" >
      <h2 style="text-align:center;margin:20px;"><u>Relevé de note</u></h2> 
    <?php foreach ($queryEtudiant as $etudiants): ?>
     <div class="row">
      <div class="col-md-4">
        <p> matricule: <?= Html::encode("{$etudiants['matricule']} ") ?> </p>
      <p> Nom: <?= Html::encode("{$etudiants['nom']} ") ?> </p>
       <p> Date d'inscription:  <?= Html::encode("{$etudiants['dateAdmission']} ") ?> </p>
       <p> Diplome préparé : Ingénieur d'état en informatique</p>

      </div>
      <div class="col-md-4">
        <p> Année d'etude : <?= Html::encode("{$etudiants['anne']} ") ?><?= Html::encode("{$etudiants['specialite']} ") ?> </p>
      <p> Prenom: <?= Html::encode("{$etudiants['prenom']} ") ?> </p>
      
      </div> 
      <div class="col-md-4">
        <p> Date de naissance : <?= Html::encode("{$etudiants['dateNaissance']} ") ?> </p>
         <p> à: <?= Html::encode("{$etudiants['lieuNaissance']} ") ?> </p>
      </div>  
     
     </div>
    <?php endforeach; ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel-body">

  <?php echo Html::a('<i class="fa fa-print" aria-hidden="true"></i>', Url::toRoute(["/Note/etudiant/impression",'anneeEtud' => $anneeEtude]),['class' =>'btn btn-primary pull-right' ,'target'=>'_blank' ]) ?>
    <table id="table" class="table text-center table-hover table-mc-light-blue table-bordered table-striped" align=center>
      <thead style="text-align:center;">
        <tr>
          <th scope="col">Semestre</th>
          <th scope="col">Nature </th>
          <th scope="col">Code</th>
          <th scope="col">Intitule(s)</th>
          <th scope="col">Coefficient</th>
          <th scope="col">Note</th>
          <th scope="col">Moyenne</th>
          <th scope="col">Session</th>
        </tr>
      </thead>
      <tbody>
   <?php $S1=0;$S2=0;$b1=0;$b2=0;
      foreach ($queryModule as $modules): 
    if($modules['semestre']==0) $S1=$S1+1;
    if($modules['semestre']==1) $S2=$S2+1;
    endforeach; ?>
       <td data-title="Semestre" rowspan="<?php echo $S1; ?>">S1</td>
    <?php foreach ($queryModule as $modules): ?>
        <?php if($modules['semestre']==0) { ?>
          <td data-title="Nature"><?= Html::encode("{$modules['nature']} ") ?> </td>
          <td data-title="Code"><?= Html::encode("{$modules['code']} ") ?>  </td>
          <td data-title="Intitule(s)"><?= Html::encode("{$modules['designation']} ") ?></td>
          <td data-title="Coefficient"><?= Html::encode("{$modules['coefficient']} ") ?></td>
          <td data-title="Note"><?= Html::encode("{$modules['valeur']} ") ?>  </td>
         <?php 
    if($b1==0) { $b1=1;?>
          <td data-title="Moyenne" rowspan="<?php echo $S1; ?>"><?= Html::encode("{$moyenneS1} ") ?>  </td>
          <td data-title="Semestre" rowspan="<?php echo $S1; ?>"><?= Html::encode("Février") ?>  </td>
          <?php } ?>
        <?php } ?>
        </tr>
       <?php endforeach; ?>


    <tr>
         <td data-title="Semestre" rowspan="<?php echo $S2+1; ?>">S2</td>
    <?php foreach ($queryModule as $modules): ?>
        <?php if($modules['semestre']==1) { ?>
          <td data-title="Nature"><?= Html::encode("{$modules['nature']} ") ?> </td>
          <td data-title="Code"><?= Html::encode("{$modules['code']} ") ?>  </td>
          <td data-title="Intitule(s)"><?= Html::encode("{$modules['designation']} ") ?></td>
          <td data-title="Coefficient"><?= Html::encode("{$modules['coefficient']} ") ?></td>
           <td data-title="Note"><?= Html::encode("{$modules['valeur']} ") ?>  </td>
           <?php if($b2==0) { $b2=1;?>
           <td data-title="Moyenne" rowspan="<?php echo $S2+1; ?>"><?= Html::encode("{$moyenneS2} ") ?>  </td>
        <td data-title="Session" rowspan="<?php echo $S2+1; ?>"><?= Html::encode("Juin") ?>  </td>
        <?php } ?>
        <?php } ?>
        </tr>
      <?php endforeach; ?>
</tbody>
</table>
 </div>      
</div>
</div>

<div class="panel-body" >
      
      <div class="row">
        <div class="col-md-4">
           <p> Moyenne Annuelle: <?= Html::encode("{$moyenneG} ") ?> </p>
         <p> Décision :  </p>
        </div>
        <div class="col-md-4">
          <p> Rang : <?= Html::encode("{$rang}") ?> / <?= Html::encode("{$nbEtudiant}") ?></p>
        </div> 
      
      </div>
    </div>

</div>
</div>
</div>