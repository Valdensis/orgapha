<?php
/************************************************************\
 *
 * File				back.senregistrer.php
 *
 * Language			PHP
 *
 * Author			David Mack
 * Creation			18 juin 2016
 * modification 
 *
 * Project			orgapha
 *
 \************************************************************/
session_start();
include_once '../database/utilisateur_manager.php';

// Créer un manager 
$utilisateur_manager = new UtilisateurManager();

// Récupérer les données du POST
$nom_utilisateur = htmlspecialchars($_POST['nom_utilisateur']);
$passe = htmlspecialchars($_POST['passe']);
$user = $utilisateur_manager->getUtilisateurParLogin($nom_utilisateur, $passe);

// Contrôle $user
if ($user != null) {
	$_SESSION['utilisateur'] = serialize($user);
	header ( "Location: /orgapha/pages/mois.php" );
} else {
	header ( "Location: /orgapha/pages/senregistrer.php" );
}