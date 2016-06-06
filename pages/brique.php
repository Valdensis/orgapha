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
if(isset($_GET["habituelle"])) { 
	$habituelle = $_GET["habituelle"];
} else {
	$habituelle = false;
}
if(isset($_GET["date"])) {
	$date = $_GET["date"];
} else {
	$aujourdhui = getdate();	// retourne un tableau
	$date = $aujourdhui["year"] . '-' . str_pad($aujourdhui["mon"],2,'0', STR_PAD_LEFT) . '-' . str_pad($aujourdhui["mday"], 2, '0', STR_PAD_LEFT);
}
if(isset($_GET["coll"])) { 
	$id_utilisateur = intval($_GET["coll"]);
	$collaborateur = $utilisateur_manager->getUtilisateur($id_utilisateur);
} else {
	$id_utilisateur = 0;
	$collaborateur = new Utilisateur(0, "Erreur", "Erreur", "Erreur", "", "", "", "", "", "", 0, 0, 0);
}
if(isset($_GET["demijour"])) {
	$demi_jour = $_GET["demijour"];
} else {
	$demi_jour = Brique::MATIN;			// "am"
}
if(isset($_GET["idbrique"])) {
	$id_brique = intval($_GET["idbrique"]);
	$brique = $brique_manager->getBrique($id_brique);
} else {
	$brique = new Brique(0, $demi_jour, $habituelle, $jour_semaine, 1, $date, "", 4, $id_utilisateur, 0);
}
?>

<body>
	<!-- Titre -->
	<table>
		<tr>
			<td><h1><?php echo $collaborateur->getNom() . ' ' . $collaborateur->getPrenom();?></h1></td>
			<td style="min-width: 40%;"></td>
			<td style="text-align: right;"><?php echo 'Brique ' . ($habituelle?'habituelle':'unique');?></td>
		</tr>
	</table>
	
</body>
