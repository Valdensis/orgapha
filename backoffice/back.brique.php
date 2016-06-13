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
include_once (dirname(__FILE__) . '/../database/brique_manager.php');
include_once (dirname(__FILE__) . '/../database/type_brique_manager.php');
//include_once (dirname(__FILE__) . '/../templates/header.inc');
include_once (dirname(__FILE__) . '/../ressources/config.php');

// Création des managers
$brique_manager = new BriqueManager();
$type_brique_manager = new TypeBriqueManager();



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
	$id = htmlspecialchars($_GET[Brique::_ID]);
	$demi_jour = htmlspecialchars($_SESSION[Brique::_DEMI_JOUR]);
	$habituelle = htmlspecialchars($_SESSION[Brique::_HABITUELLE]);
	if ($habituelle) {
		// TODO $jour_semaine = 
	} else {
		
	}
	
	
	// TODO
}

function supprimer_brique() {
	// TODO
}

function creer_habituelle() {
	// TODO
}