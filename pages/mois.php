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

include_once(dirname(__FILE__) . '/../database/type_collaborateur_manager.php');
include_once(dirname(__FILE__) . '/../database/brique_manager.php');
include_once(dirname(__FILE__) . '/../database/utilisateur_manager.php');
include_once(dirname(__FILE__) . '/../database/type_brique_manager.php');
include_once(dirname(__FILE__) . '/../templates/header.inc');
include_once(dirname(__FILE__) . '/../ressources/config.php');


// Cr�ation des Manager
$brique_manager = new BriqueManager();
$utilisateur_manager = new UtilisateurManager();
$type_brique_manager = new TypeBriqueManager();
$type_collaborateur_manager = new TypeCollaborateurManager();

// R�cup�ration du mois � afficher dans le GET, s'il n'y en a pas, met le mois courant
$aujourdhui = getdate();	// retourne un tableau
//print_r("*" . strftime("%w", mktime(0,0,0,6,1,2016)) . "*"); // affiche *3* pour mercredi
$mois = $aujourdhui["mon"];
$annee = $aujourdhui["year"];
if(isset($_GET["mois"]))
	$mois = $_GET["mois"];
if(isset($_GET["annee"]))
	$annee = $_GET["annee"];

// D�finir les mois et ann�es pr�c�dents et suivants
$moisSuivant = ($mois % 12) + 1;
$moisPrecedent = (($mois + 10) % 12) + 1;
$anneeSuivante = $annee;
$anneePrecedente = $annee;

if($moisSuivant == 1) {
	$anneeSuivante = $annee + 1;
} elseif ($moisPrecedent == 12) {
	$anneePrecedente = $annee - 1;
}

// D�finition du nombre de jours du mois courant
$nbJours = nbJoursMois($mois, $annee);

// R�cup�rer tous les types de collaborateurs
$types_collaborateur = $type_collaborateur_manager->getAllTypeCollaborateurs();

// Fonction transformant le num�ro du mois en nom de mois
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
	<!-- Tableau du mois -->
	<table>
		<tr>
			<th align="left">Collaborateur</th>
			<?php for ($i = 1; $i <= $nbJours; $i++) { ?>
				<th class="cellule_titre" <?php if (strftime("%w", mktime(0,0,0,$mois,$i,$annee)) == 0) echo 'style="background-color: ' . COULEUR_DIMANCHE .'"';?>><?php echo $i?></th><!-- %w = jour de la semaine, 0 pour dimanche -->
			<?php } ?>
		</tr>
		<!-- Pour chaque type de collaborateur -->
		<?php foreach ($types_collaborateur as $type) {	?> 
				<tr>
					<th align="left" colspan="<?php echo $nbJours + 1;?>"><?php echo $type->getDesignation()?></th>
				</tr>
				<!-- R�cup�rer les collaborateurs de ce type -->
				<?php $collaborateurs = $utilisateur_manager->getAllUtilisateursParType((Integer) $type->getId(), true);
				if($collaborateurs == null) { ?>
					<tr><td><em>Aucun collaborateur</em><td></tr>
				<?php } else {?>
					<!-- Pour chaque collaborateur -->
					<?php foreach ($collaborateurs as $coll) {?>
					<tr>
						<td><?php echo $coll->getPrenom();?></td>
						<!-- Une case par jour sur la ligne -->
						<?php for ($i = 1; $i <= $nbJours; $i++) {?>
							<td><button class="cellule" ></button></td>
						<?php }?>
					</tr>
					<?php }?>
				<?php }?>
		<?php }?>
	</table>

</html>
