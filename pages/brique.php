<?php
/************************************************************\
 *
 * File				brique.php
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
include_once (dirname(__FILE__) . '/../database/utilisateur_manager.php');
include_once (dirname(__FILE__) . '/../database/brique_manager.php');
include_once (dirname(__FILE__) . '/../database/type_brique_manager.php');
include_once (dirname(__FILE__) . '/../templates/header.inc');
include_once (dirname(__FILE__) . '/../ressources/config.php');

// Création des Managers
$brique_manager = new BriqueManager();
$utilisateur_manager = new UtilisateurManager();
$type_brique_manager = new TypeBriqueManager();

// Récupération des données dans le GET
if(isset($_GET["habituelle"])) $habituelle = $_GET["habituelle"];
if(isset($_GET["date"])) $date = $_GET["date"];
if(isset($_GET["coll"]))$id_utilisateur = $_GET["coll"];
if(isset($_GET["demijour"])) $demijour = $_GET["demijour"];
if(isset($_GET["idbrique"]))$id_brique = $_GET["idbrique"];

// Récupération de la brique et contrôle de concordance
