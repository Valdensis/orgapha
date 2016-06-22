<?php
/************************************************************\
 *
 * File				back.brique.php
 *
 * Language			PHP
 *
 * Author			David Mack
 * Creation			6 juin 2016
 * modification 
 *
 * Project			orgapha
 *
 \************************************************************/
session_start();
include_once (dirname(__FILE__) . '/../database/brique_manager.php');
include_once (dirname(__FILE__) . '/../database/type_brique_manager.php');
//include_once (dirname(__FILE__) . '/../templates/header.inc');
include_once (dirname(__FILE__) . '/../ressources/config.php');

// Capture de l'action utilisateur
if (isset($_POST["retour_semaine"])) {
	retour_semaine();
}
if (isset($_POST["retour_mois"])) {
	retour_mois();
}
if (isset($_POST["enregistrer"])) {
	enregistrer_brique();
}
if (isset($_POST["supprimer"])) {
	supprimer_brique();
}
if (isset($_POST["creer_habituelle"])) {
	creer_habituelle();
}

function retour_semaine() {
	header("location:/../orgapha/pages/semaine.php");
}

function retour_mois() {
	$mois = isset($_POST["date"]) ? substr($_POST["date"], 5, 2) : getdate()["mon"];
	$annee = isset($_POST["date"]) ? substr($_POST["date"], 0, 4) : getdate()["year"];
	header("location:/../orgapha/pages/mois.php?mois=" . $mois . "&annee=" . $annee);
}

function enregistrer_brique() {
	// Création des managers
	$brique_manager = new BriqueManager();
	
	// Récupération de tous les champs
	$id = htmlspecialchars($_GET[Brique::_ID]);
	$demi_jour = htmlspecialchars($_POST[Brique::_DEMI_JOUR]);
	$habituelle = htmlspecialchars($_GET[Brique::_HABITUELLE]);
	if ($habituelle) {
		// briques habituelles
		$jour_semaine = htmlspecialchars($_POST[Brique::_JOUR_SEMAINE]);
		$frequence = htmlspecialchars($_POST[Brique::_FREQUENCE]);
		// briques uniques, champs inutiles
		$date="1900-01-01";
	} else {
		// briques habituelles, champs inutiles
		$jour_semaine = 0;
		$frequence = 1;
		// briques uniques
		$date = htmlspecialchars($_POST[Brique::_DATE]);
	}
	$texte = htmlspecialchars($_POST[Brique::_TEXTE]);
	$duree = htmlspecialchars($_POST[Brique::_DUREE]);
	$utilisateur = htmlspecialchars($_GET["coll"]);
	$type_brique = htmlspecialchars($_POST[Brique::_TYPE_BRIQUE]);
	
	// Contrôle des champs
	// TODO au moins la date...
	
	// Créer la brique
	$brique = new Brique($id, $demi_jour, $habituelle, $jour_semaine, $frequence, $date, $texte, $duree, $utilisateur, $type_brique);
	
	// Enregistrer la brique
	if ($id > 0) {
		// Mettre à jour la brique
		$brique_manager->updateBrique($brique);
		$msg = 'Brique mise à jour !';
		$rank = 'resultat';
	} else {
		// Créer une nouvelle brique
		$result = $brique_manager->createBrique($brique);
		$msg = 'Brique créée !';
		$rank = 'resultat';
		$brique->setId($result);
	}
	
	// Enregistrer le message dans la session et retourner à la brique
	$_SESSION['rank'] = $rank;
	$_SESSION['msg'] = $msg;
	if ($brique->isHabituelle()) {
		header("location:/orgapha/pages/brique.php?habituelle=1&coll=" . $brique->getUtilisateur() . "&demijour=" . $brique->getDemi_jour() . "&jour_semaine=" . $brique->getJour_semaine() . "&idbrique=" . $brique->getId());
		exit;
	} else {
		header("location:/orgapha/pages/brique.php?habituelle=0&coll=" . $brique->getUtilisateur() . "&demijour=" . $brique->getDemi_jour() . "&date=" . $brique->getDate() . "&idbrique=" . $brique->getId());
		exit;
	}	
}

function supprimer_brique() {
	// Création du manager
	$brique_manager = new BriqueManager();
	
	// Brique à détruire
	$id = htmlspecialchars($_GET[Brique::_ID]);
	$brique = $brique_manager->getBrique($id);
	$brique_manager->deleteBrique($brique);
	
	// Retour au mois ou à la semaine
	$_SESSION['rank'] = 'resultat';
	if ($brique->isHabituelle()) {
		// retour à la semaine
		$_SESSION['msg'] = 'Brique ' . $brique->getId() . ' : ' . $brique->getJour_semaine() . ' ' . $brique->getDemi_jour() . ' supprimée !';
		header("location:/orgapha/pages/semaine.php");
		exit;
	} else {
		// retour au mois
		$_SESSION['msg'] = 'Brique ' . $brique->getId() . ' : ' . $brique->getDate() . ' ' . $brique->getDemi_jour() . ' supprimée !';
		header("location:/orgapha/pages/mois.php?mois=" . substr($brique->getDate(), 5, 2) . "&annee=" . substr($brique->getDate(), 0, 4));
		exit;
	}
	
	
}

function creer_habituelle() {
	// TODO : créer brique habituelle à partir d'une brique unique déjà créée
}