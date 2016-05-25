<?php
/************************************************************\
 *
 * File				mois.php
 *
 * Language			PHP
 *
 * Author			David Mack
 * Creation			25 mai 2016
 * modification 
 *
 * Project			orgapha
 *
 \************************************************************/

include_once(dirname(__FILE__) . '/../database/brique_manager.php');
include_once(dirname(__FILE__) . '/../database/utilisateur_manager.php');
include_once(dirname(__FILE__) . '/../database/type_brique_manager.php');

// Récupération du mois à afficher dans le GET, s'il n'y en a pas, met le mois courant
$aujourdhui = getdate();	// retourne un tableau
$mois = $aujourdhui["mon"];
$annee = $aujourdhui["year"];
if(isset($_GET["mois"]))
	$mois = $_GET["mois"];
if(isset($_get["annee"]))
	$annee = $_GET["annee"];

// Définir les mois et années précédents et suivants
$moisSuivant = ($mois % 12) + 1;
$moisPrecedent = (($mois + 10) % 12) + 1;
$anneeSuivante = $annee;
$anneePrecedente = $annee;

if($moisSuivant == 1) {
	$anneeSuivante = $annee + 1;
} elseif ($moisPrecedent == 12) {
	$anneePrecedente = $annee - 1;
}

// Définition du nombre de jours du mois courant
$nbJours = nbJoursMois($mois, $annee);

// Fonction transformant le numéro du mois en nom de mois
function nomMois($noMois) {
	$nomMois = "";
	$nomsMois = array("", "Janvier", "Fevrier", "Mars", "Avril", "Mai",
			"Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre");
	return $nomsMois[$noMois];
}

// Fonction donnant le nombre de jours
function nbJoursMois($noMois, $annee)
{
	$reponse = 31;
	switch ($noMois) {
		case 4:
		case 6:
		case 9:
		case 10:
			$reponse = 30;
			break;
		case 2:
			$reponse = 28;
			if ($annee % 4 == 0)
				$reponse = 29;
				break;
	}
	return $reponse;
}
?>
<html>
	<!-- Titre -->
	<div>
		<h1 style="display: inline;">
			<a id="anPrecedent" class="bouton" href="mois.php?mois=<?php echo $mois?>&annee=<?php echo $annee-1?>">&lt;&lt;</a>
			<a id="precedent" class="bouton" href="mois.php?mois=<?php echo $moisPrecedent?>
							&annee=<?php echo $anneePrecedente?>">&lt;</a>
			&nbsp;<?php echo nomMois($mois);?>
			&nbsp;<?php echo $annee?>
			&nbsp;
			<a id="suivant" class="bouton" href="mois.php?mois=<?php echo $moisSuivant?>
							&annee=<?php echo $anneeSuivante?>">&gt;</a>
			<a id="anSuivant" class="bouton" href="mois.php?mois=<?php echo $mois?>&annee=<?php echo $annee+1?>">&gt;&gt;</a>
			
		</h1>				
	</div>

</html>
