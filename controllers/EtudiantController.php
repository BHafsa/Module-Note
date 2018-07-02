<?php

namespace humhub\modules\note\controllers;

use humhub\modules\note\utils\FPDF\FPDF;
use Yii;

class EtudiantController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //Pour recupere l'aané d'étude
        if (isset($_GET['anneeEtud'])) {//Si année saisit
            $anneeEtude = $_GET['anneeEtud'];  //prendre l'anné sisait
        } else {
            $anneeEtude = date('Y');
        } //prendre l'anné en court

        $iduser = Yii::$app->user->getId();//recuperer l'id de l'utilisateur

        //recuperer la table des année d'étude de l'étudiant
        $anneeEtudeTab = Yii::$app->db->createCommand('SELECT date from releve join etudiant where releve.idEtudiant=etudiant.idEtudiant and etudiant.id=' . $iduser . ' GROUP BY date')->queryAll();

        //récuperer les information de l'étudiant
        $commandeEtudiant = Yii::$app->db->createCommand('select matricule,nom,prenom,dateNaissance,lieuNaissance,dateAdmission,anne,specialite,date from etudiant join groupe join niveau join releve on etudiant.idGroupe=groupe.idGroupe and groupe.idNiveau=niveau.idNiveau and etudiant.id=' . $iduser . ' and releve.idEtudiant=etudiant.idEtudiant and releve.date="' . $anneeEtude . '" GROUP BY date');
        $queryEtudiant = $commandeEtudiant->queryAll();

        //récupérer le niveau d'étude de l'étudiant
        $commandeNiveau = Yii::$app->db->createCommand('select anne from etudiant join groupe join niveau join releve on etudiant.idGroupe=groupe.idGroupe and groupe.idNiveau=niveau.idNiveau and etudiant.id=' . $iduser . ' and releve.date="' . $anneeEtude . '" and releve.idEtudiant=etudiant.idEtudiant');
        $queryNiveau = $commandeNiveau->queryScalar();

        //récupérer les note de l'étudiant selon l'anné d''étude
        $commandeModule = Yii::$app->db->createCommand('select nature,code,semestre,designation,coefficient,valeur from UE join module join note join releve join etudiant on releve.idEtudiant=etudiant.idEtudiant and etudiant.id=' . $iduser . ' and UE.idUE=module.idUE  and releve.idModule=module.idModule  and releve.date="' . $anneeEtude . '" and releve.idNote=note.idNote');
        $queryModule = $commandeModule->queryAll();

        //calcule des moyennes semestriels et la moy génerale
        $moyenneS1 = $this->actionCalculMoyenneS($iduser, 0, $anneeEtude);
        $moyenneS2 = $this->actionCalculMoyenneS($iduser, 1, $anneeEtude);
        $moyenneG = ($moyenneS1 + $moyenneS2) / 2;


        //récuperer nombre d'étudiant de la promo selon l'anné d'tude et le nineau
        $nbEtudiantCommande = Yii::$app->db->createCommand('select id from niveau join releve join etudiant
			join groupe where etudiant.idGroupe=groupe.idGroupe and groupe.idNiveau=niveau.idNiveau and
			niveau.anne="' . $queryNiveau . '" and releve.date="' . $anneeEtude . '" and 
			releve.idEtudiant=etudiant.idEtudiant group by id')->queryAll();
        $nbEtudiant = sizeof($nbEtudiantCommande);

        //calcule du rang
        $rang = $this->rang($moyenneG, $anneeEtude, $nbEtudiantCommande);


        //passer les variable vers le views
        return $this->render('index',
            ['queryModule' => $queryModule,
                'queryEtudiant' => $queryEtudiant, 'moyenneG' => $moyenneG,
                'moyenneS1' => $moyenneS1, 'moyenneS2' => $moyenneS2, 'anneeEtudeTab' => $anneeEtudeTab
                , 'anneeEtude' => $anneeEtude, 'rang' => $rang, 'nbEtudiant' => $nbEtudiant]
        );


    }

    //fonction qui calcule la moyen semestriel d'un étudiant selon l'anné d'étude
    public function actionCalculMoyenneS($iduser, $semestre, $anneeEtude)
    {
        $commande = Yii::$app->db->createCommand('select sum((valeur*coefficient)/(select sum(coefficient) from
    	UE join module join etudiant join groupe join niveau where etudiant.id=' . $iduser . ' and
    	etudiant.idGroupe=groupe.idGroupe and groupe.idNiveau=niveau.idNiveau and UE.idNiveau=niveau.idNiveau
    	and UE.idUE=module.idUE and UE.semestre=' . $semestre . ')) as moyen from etudiant join module join releve
    	join note join UE
		where etudiant.id=' . $iduser . '  and releve.idEtudiant=etudiant.idEtudiant and
		releve.idModule=module.idModule and UE.semestre=' . $semestre . ' and releve.date="' . $anneeEtude . '" and
		releve.idNote=note.idNote and UE.idUE=module.idUE');
        $moyenne = $commande->queryScalar();
        //reduire nbre chiffre apres la virgule !!!!!!
        return ($moyenne);
    }

    //calculer le rang de l'étudiant
    public function rang($moyenneG, $anneeEtude, $tabEtdiant)
    {
        $cpt = 0;
        $tab = array();
        foreach ($tabEtdiant as $com) : //calculer la moyenne pour chaque étudiant de la promo
            $moyenS1 = $this->actionCalculMoyenneS($com['id'], 0, $anneeEtude);
            $moyenS2 = $this->actionCalculMoyenneS($com['id'], 1, $anneeEtude);
            $tab[$cpt] = ($moyenS1 + $moyenS2) / 2;
            $cpt = $cpt + 1;
        endforeach;
        asort($tab);//classer les moyenne
        $rang = 0;
        for ($i = 0; $i < sizeof($tab); $i++) {
            if ($tab[$i] == $moyenneG) $rang = $i; //recuperer le rang de l'éléve
        }
        return ($rang + 1);

    }

    //impression du relevé
    public function actionImpression()
    {
        //Pour recupere l'aané d'étude
        if (isset($_GET["anneeEtud"])) {
            $anneeEtude = $_GET["anneeEtud"];

        } else {
            $anneeEtude = date('Y');
        }

        //Pour recupere l'id de l'utilisateur
        $iduser = Yii::$app->user->getId();

        //récuperer infos étudiant
        $Etudiants = Yii::$app->db->createCommand('select matricule,nom,prenom,dateNaissance,lieuNaissance,dateAdmission,anne,specialite,date from etudiant join groupe join niveau join releve on etudiant.idGroupe=groupe.idGroupe and groupe.idNiveau=niveau.idNiveau and etudiant.id=' . $iduser . ' and releve.idEtudiant=etudiant.idEtudiant and releve.date="' . $anneeEtude . '" GROUP BY date')->queryAll();
        //récuperer note étudiant
        $Modules = Yii::$app->db->createCommand('select nature,code,semestre,designation,coefficient,valeur from UE join module join note join releve join etudiant on releve.idEtudiant=etudiant.idEtudiant and etudiant.id=' . $iduser . ' and UE.idUE=module.idUE  and releve.idModule=module.idModule and releve.idNote=note.idNote and releve.date="' . $anneeEtude . '"')->queryAll();

        //création du pdf
        //Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'application/pdf');
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 30);

        //Le titre
        $pdf->SetY(8);
        $pdf->SetX(64);
        $pdf->Cell(40, 10, utf8_decode('Relvé de note'));
        $pdf->Ln();
        $pdf->Ln();

        //section information étudiant
        $pdf->SetX(8);
        $pdf->SetFontSize(10);
        foreach ($Etudiants as $Etudiant):
            $pdf->Cell(40, 10, 'Matricule Etudant : ' . $Etudiant['matricule']);
            $pdf->SetX(66);
            $pdf->Cell(40, 10, utf8_decode('Année d\'etude  : ' . $Etudiant['anne']));
            $pdf->SetX(120);
            $pdf->Cell(40, 10, 'Date de naissance : ' . $Etudiant['dateNaissance']);
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->Cell(40, 10, 'Nom  : ' . $Etudiant['nom']);
            $pdf->SetX(66);
            $pdf->Cell(40, 10, 'Prenom  : ' . $Etudiant['prenom']);
            $pdf->SetX(126);
            $pdf->Cell(40, 10, utf8_decode('à  : ' . $Etudiant['lieuNaissance']));
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->Cell(40, 10, 'Date d\'inscription  : ' . $Etudiant['dateAdmission']);
            $pdf->Ln();
            $pdf->SetX(8);
        endforeach;

        //entete du tableau
        $pdf->SetDrawColor(183); // Couleur du fond
        $pdf->SetFillColor(221); // Couleur des filets
        $pdf->SetTextColor(0); // Couleur du texte
        $pdf->SetY(70);

        $pdf->SetX(8);
        $pdf->Cell(20, 8, 'Semestre', 1, 0, 'C', 1);

        $pdf->SetX(28); // 8 + 72
        $pdf->Cell(40, 8, 'Nature', 1, 0, 'C', 1);

        $pdf->SetX(68); // 80+10
        $pdf->Cell(20, 8, 'Code', 1, 0, 'C', 1);

        $pdf->SetX(88); // 104 + 20
        $pdf->Cell(20, 8, 'Module', 1, 0, 'C', 1);

        $pdf->SetX(108); // 104 + 20
        $pdf->Cell(20, 8, 'Coefficiant', 1, 0, 'C', 1);

        $pdf->SetX(128); // 104 + 20
        $pdf->Cell(20, 8, 'Note', 1, 0, 'C', 1);

        $pdf->SetX(148); // 104 + 20
        $pdf->Cell(20, 8, 'Moyenne', 1, 0, 'C', 1);

        $pdf->SetX(168); // 104 + 20
        $pdf->Cell(20, 8, 'Session', 1, 0, 'C', 1);
        $pdf->Ln(); // Retour à la ligne
        $position = 78;
        //fin des entetes


        //la colonne semmestre
        $S1 = 0;
        $S2 = 0;
        foreach ($Modules as $Module):
            if ($Module['semestre'] == 0) $S1 = $S1 + 1;
            if ($Module['semestre'] == 1) $S2 = $S2 + 1;
        endforeach;

        $pdf->SetY($position);
        $pdf->SetX(8);
        $pdf->MultiCell(20, 8 * $S1, '1', 1, 'C');
        $pdf->SetY($position + 8 * $S1);
        $pdf->SetX(8);
        $pdf->MultiCell(20, 8 * $S2, '2', 1, 'C');

        //Colonne moyenns semestriels
        $pdf->SetY($position);
        $pdf->SetX(148);
        $moyenneS1 = $this->actionCalculMoyenneS($iduser, 0, $anneeEtude);
        $pdf->MultiCell(20, 8 * $S1, $moyenneS1, 1, 'C');
        $pdf->SetY($position + 8 * $S1);
        $pdf->SetX(148);
        $moyenneS2 = $this->actionCalculMoyenneS($iduser, 1, $anneeEtude);
        $pdf->MultiCell(20, 8 * $S2, $moyenneS2, 1, 'C');

        //colonnes secssion
        $pdf->SetY($position);
        $pdf->SetX(168);
        $pdf->MultiCell(20, 8 * $S1, utf8_decode('Février'), 1, 'C');
        $pdf->SetY($position + 8 * $S1);
        $pdf->SetX(168);
        $pdf->MultiCell(20, 8 * $S2, 'Juin', 1, 'C');


        //tableau de note
        foreach ($Modules as $Module):
            $pdf->SetY($position);
            $pdf->SetX(28);
            $pdf->MultiCell(40, 8, utf8_decode($Module['nature']), 1, 'C');
            $pdf->SetY($position);
            $pdf->SetX(68);
            $pdf->MultiCell(20, 8, $Module['code'], 1, 'R');
            $pdf->SetY($position);
            $pdf->SetX(88);
            $pdf->MultiCell(20, 8, $Module['designation'], 1, 'R');
            $pdf->SetY($position);
            $pdf->SetX(108);
            $pdf->MultiCell(20, 8, $Module['coefficient'], 1, 'R');
            $pdf->SetY($position);
            $pdf->SetX(128);
            $pdf->MultiCell(20, 8, $Module['valeur'], 1, 'R');
            $position = $position + 8;

        endforeach;

        //moyenne génerale
        $pdf->SetY($position + 8);
        $pdf->SetX(8);
        $pdf->Cell($position + 8, 10, 'Moyenne Annuaire ' . ($moyenneS1 + $moyenneS2) / 2);
        $pdf->Ln();
        $pdf->SetX(8);
        $pdf->Cell(40, 10, 'Decision: ');

        //le rang
        $commandeNiveau = Yii::$app->db->createCommand('select anne from etudiant join groupe join niveau join
	  	releve on etudiant.idGroupe=groupe.idGroupe and groupe.idNiveau=niveau.idNiveau and etudiant.id=' . $iduser . ' and releve.date="' . $anneeEtude . '" and releve.idEtudiant=etudiant.idEtudiant');
        $queryNiveau = $commandeNiveau->queryScalar();
        $nbEtudiant = Yii::$app->db->createCommand('select id from niveau join releve join etudiant join groupe
		where etudiant.idGroupe=groupe.idGroupe and groupe.idNiveau=niveau.idNiveau and niveau.anne="' . $queryNiveau . '" and releve.date="' . $anneeEtude . '" and releve.idEtudiant=etudiant.idEtudiant group
		by id')->queryAll();
        $rang = $this->rang(($moyenneS1 + $moyenneS2) / 2, $anneeEtude, $nbEtudiant);
        $pdf->SetX(66);
        $pdf->Cell(40, 10, 'Rang  : ' . $rang . '/' . sizeof($nbEtudiant));

        //telechargement du pdf
        $pdf->Output("imp.pdf", 'd');

    }
}
