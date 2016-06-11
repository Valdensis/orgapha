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


// Création des Managers
$brique_manager = new BriqueManager();
$utilisateur_manager = new UtilisateurManager();
$type_brique_manager = new TypeBriqueManager();
$type_collaborateur_manager = new TypeCollaborateurManager();

// Récupération du mois à afficher dans le GET, s'il n'y en a pas, met le mois courant
$aujourdhui = getdate();	// retourne un tableau
//print_r("*" . strftime("%w", mktime(0,0,0,6,1,2016)) . "*"); // affiche *3* pour mercredi
$mois = $aujourdhui["mon"];
$annee = $aujourdhui["year"];
if(isset($_GET["mois"]))
	$mois = $_GET["mois"];
if(isset($_GET["annee"]))
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

// Récupérer tous les types de collaborateurs
$types_collaborateur = $type_collaborateur_manager->getAllTypeCollaborateurs();

// Fonction transformant le numéro du mois en nom de mois
function nomMois($noMois) {
	$noMois = intval($noMois);
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

	
<body>

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
			<!-- Jours 1 à 28-31 en tête de colonne -->
			<?php for ($i = 1; $i <= $nbJours; $i++) { ?>
				<th class="cellule_titre" <?php if (strftime("%w", mktime(0,0,0,$mois,$i,$annee)) == 0) echo 'style="background-color: ' . COULEUR_DIMANCHE .'; color: white;"';?>><?php echo $i?></th><!-- %w = jour de la semaine, 0 pour dimanche -->
			<?php } ?>
		</tr>
		<!-- Pour chaque type de collaborateur -->
		<?php foreach ($types_collaborateur as $type) {	?> 
				<tr>
					<th align="left" colspan="<?php echo $nbJours + 1;?>"><?php echo $type->getDesignation()?></th>
				</tr>
				<!-- Récupérer les collaborateurs de ce type -->
				<?php $collaborateurs = $utilisateur_manager->getAllUtilisateursParType((Integer) $type->getId(), true);
				if($collaborateurs == null) { ?>
					<tr><td><em>Aucun collaborateur</em><td></tr>
				<?php } else {?>
					<!-- Pour chaque collaborateur -->
					<?php foreach ($collaborateurs as $coll) {?>
					<tr>
						<td rowspan="2"><?php echo $coll->getPrenom();?></td>
						<!-- on passe 2 fois cette boucle, une fois pour le matin, une fois pour l'après-midi -->
						<?php for ($demi = 0; $demi < 2; $demi++) {
						$ampm = ($demi == 0) ? Brique::MATIN : Brique::APRES_MIDI;	
							?>
							<!-- Une case par jour sur la ligne du matin -->
							<?php for ($i = 1; $i <= $nbJours; $i++) {
								
								/* Il y a 3 cas : dimanche, brique existante, ou rien. Une brique existante l'emporte sur un dimanche */
								
								// transformer les infos disponibles en date au format aaaa-mm-jj
								$cejour = $annee . '-' . str_pad($mois,2,'0', STR_PAD_LEFT) . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
								// créer la chaîne de caractères pour le href, correspondant aux données disponibles
								$href = "brique.php?habituelle=0&coll=" . $coll->getId() . "&demijour=" . $ampm . "&date=" . $cejour;
								// chercher si une brique existe pour cette case
								$brique = $brique_manager->getBriqueUnique($coll->getId(), $ampm, $cejour);
		
								if ($brique != null) { ?>
									<!-- Cas où une brique existe -->
									<td  style="background-color: <?php echo $brique_manager->getColor($brique);?>">
										<a class="cellule" href="<?php echo $href . "&idbrique=" . $brique->getId();?>"><?php echo $brique->getTexte();?></a>
									</td>
								<?php } 
								elseif (strftime("%w", mktime(0,0,0,$mois,$i,$annee)) == 0) {?>
									<!-- Cas où c'est un dimanche -->
									<td  style="background-color: <?php echo COULEUR_DIMANCHE;?>; color: white;">
										<a class="cellule" href="<?php echo $href;?>"></a>
									</td>
								<?php } else { ?>
									<!-- Cas où il n'y a rien, on met une case blanche -->
									<td style="background-color: #eee" >
										<a class="cellule" href="<?php echo $href;?>"></a>
									</td>
								<?php } // fin if elseif?>	
							<?php } // fin for $i?>
							</tr>
							<tr>		
						<?php }	// fin for $demi?>
					</tr>
					<?php }?>
				<?php }?>
		<?php }?>
	</table>
</body>
</html>
