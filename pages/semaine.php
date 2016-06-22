<?php
/************************************************************\
 *
 * File				semaine.php
 *
 * Language			PHP
 *
 * Author			David Mack
 * Creation			12 juin 2016
 * modification 
 *
 * Project			orgapha
 *
 \************************************************************/
include_once '../database/brique_manager.php';
include_once '../database/utilisateur_manager.php';
include_once '../database/type_brique_manager.php';
include_once '../database/type_collaborateur_manager.php';
include_once '../templates/header.inc';
include_once '../ressources/config.php';

// Création des managers
$brique_manager = new BriqueManager();
$utilisateur_manager = new UtilisateurManager();
$type_brique_manager = new TypeBriqueManager();
$type_collaborateur_manager = new TypeCollaborateurManager();

// Récupération d'un message
// TODO Gestion des messages dans la semaine.php
$msg = isset($_SESSION['msg']) ? '<span class="erreur" >* ' . $_SESSION['msg'] . '</span>' : '';
if (isset($_SESSION['rank'])) {
	$rank = $_SESSION['rank'];
	unset($_SESSION['rank']);
} else {
	$rank = '';
}

// Récupérer les types de collaborateurs
$types_collaborateur = $type_collaborateur_manager->getAllTypeCollaborateurs();

// Fonction retournant le numéro du jour en nom de jour
function nomJour($noJour) {
	$nomsJours = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");
	return $nomsJours[$noJour];
}
?>
<body>
	<!-- Titre -->
	<div>
		<h1>Semaine de travail standard</h1>
	</div>
	<!-- Tableau de la semaine -->
	<table>
		<!-- Ligne d'en-tête -->
		<tr>
			<th align="left">Collaborateur</th>
			<?php for ($noJour = 1; $noJour < 7; $noJour++) {
				echo '<th class="cellule_semaine cellule_titre_semaine">' . nomJour($noJour) . '</th>'; 
			}?>
		</tr>
		<!-- Pour chaque type de collaborateur -->
		<?php foreach ($types_collaborateur as $type) {?>
			<tr>
				<th align="left" colspan="8"><?php echo $type->getDesignation();?></th>
			</tr>
			<!-- Récupérer les collaborateurs de ce type -->
			<?php $collaborateurs = $utilisateur_manager->getAllUtilisateursParType((Integer) $type->getId(), true);
			if ($collaborateurs == null) { ?>
				<tr><td><em>Aucun collaborateur</em></td></tr>
			<?php } else { ?>
				<!-- Pour chaque collaborateur -->
				<?php foreach ($collaborateurs as $coll) { ?>
				<tr>	
					<td rowspan="2"><?php echo $coll->getPrenom();?></td>
					<!-- on passe 2 fois cette boucle, une fois pour le matin, une fois pour l'après-midi -->
					<?php for ($demi = 0; $demi < 2; $demi++) {
					$ampm = ($demi == 0) ? Brique::MATIN : Brique::APRES_MIDI ?>
						<!-- Une case par jour sur la ligne de la demi-journée -->
						<?php for ($i = 1; $i < 7; $i++) {
							/* Il y a 2 cas : soit il existe une brique, soit non */ 
							
							// Créer la chaîne de caractères pour la href, correspondant aux données disponibles 
							$href = "/orgapha/pages/brique.php?habituelle=1&coll=" . $coll->getId() . "&demijour=" . $ampm . "&joursemaine=" . $i;
							
							// Chercher si une brique existe pour cette case
							$brique = $brique_manager->getBriqueHabituelle($coll->getId(), $ampm, $i);
							
							if ($brique != null) { ?>
								<!-- Cas ou une brique existe -->
								<td style="background-color: <?php echo $brique_manager->getColor($brique)?>">
									<a class="cellule_semaine" href="<?php echo $href . "&idbrique=" . $brique->getId()?>"><?php echo '1/' . 1/$brique->getFrequence() . ' - ' . $brique->getDuree() . 'h. ' . $brique->getTexte();?></a>
								</td>
							<?php } else { ?>
								<!-- Cas ou il n'y a rien -->
								<td style="background-color: #eee" >
									<a class="cellule_semaine" href="<?php echo $href;?>">&nbsp;</a>
								</td>
							<?php } ?>
							<!-- Cellule vide du dimanche : omise -->
						<?php } // fin de la boucle ligne demi-journée for $i?>
						<!-- Mettre un bouton en bout de ligne am -->
							<?php if ($demi == 0) { ?>
								<td rowspan="2">
									<a class="bouton" href="/orgapha/pages/propagation.php?id=<?php echo $coll->getId()?>">Copier</a>
								</td>
							<?php } ?>
						</tr>
						<tr>
					<?php } // fin de la boucle for $demi?>
				</tr>	
				<?php }   // fin foreach collaborateur ?>
			<?php } // fin if else $collaborateurs vide ?>
		<?php }  // fin foreach $type_collaborateur ?>
	</table>
</body>
