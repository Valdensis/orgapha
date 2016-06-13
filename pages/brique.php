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
if(isset($_GET["joursemaine"])) {
	$jour_semaine = $_GET["joursemaine"];
} else {
	$jour_semaine = null;
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

// Récupération des messages d'erreur.
$rank = isset($_SESSION['rank']) ? $_SESSION['rank'] : '';
$msg = isset($_SESSION['msg']) ? '<span class="erreur" >* ' . $_SESSION['msg'] . '</span>' : '';
$form_data_brique = isset($_SESSION['form_data_brique']) ? $_SESSION['form_data_brique'] : array (
		'jour_semaine' => '',
		'date' => '',
		'demi_jour' => '',
		'frequence' => '',
		'type_brique' => '',
		'duree' => '',
		'texte'=> ''
);
if (isset($_SESSION['form_data_brique'])) unset($_SESSION['form_data_brique']);

?>
<head><script type="text/javascript" src="datePicker.js" ></script>
<title>Brique</title>
</head>
<body>
	<!-- Titre -->
	<table>
		<tr>
			<td><h1><?php echo $collaborateur->getNom() . ' ' . $collaborateur->getPrenom();?></h1></td>
			<td style="min-width: 40%;"></td>
			<td style="text-align: right;"><?php echo 'Brique ' . ($habituelle?'habituelle':'unique');?></td>
		</tr>
	</table>
	<!-- Formulaire de saisie de la brique -->
	<form method="post" action="../backoffice/back.brique.php?id=<?php echo $brique->getId();?>">
		<table>
		<!-- jour de la semaine (que si c'est une brique habituelle) -->
		<?php if ($habituelle == true) {?>
			<tr>
				<td>Jour de la semaine :</td>
				<td>
					<select name="jour_semaine">
						<option value=1 <?php if ($form_data_brique[Brique::_JOUR_SEMAINE] == 1 ) echo 'selected="selected"' ?>>lundi</option>
						<option value=2 <?php if ($form_data_brique[Brique::_JOUR_SEMAINE] == 2 ) echo 'selected="selected"' ?>>mardi</option>
						<option value=3 <?php if ($form_data_brique[Brique::_JOUR_SEMAINE] == 3 ) echo 'selected="selected"' ?>>mercredi</option>
						<option value=4 <?php if ($form_data_brique[Brique::_JOUR_SEMAINE] == 4 ) echo 'selected="selected"' ?>>jeudi</option>
						<option value=5 <?php if ($form_data_brique[Brique::_JOUR_SEMAINE] == 5 ) echo 'selected="selected"' ?>>vendredi</option>
						<option value=6 <?php if ($form_data_brique[Brique::_JOUR_SEMAINE] == 6 ) echo 'selected="selected"' ?>>samedi</option>
						<option value=0 <?php if ($form_data_brique[Brique::_JOUR_SEMAINE] == 0 ) echo 'selected="selected"' ?>>dimanche</option>
					</select>
				</td>
			</tr>
		<?php }?>
		<!-- date (que si c'est une brique unique) -->
		<?php if ($habituelle == false) { ?>
			<tr>
				<td>Date [aaaa-mm-jj] :</td>
				<td><input type="text" name="date" value="<?php echo $date;?>"></td>
				<!-- td><input type="text" name="date" readonly="readonly" value="<?php echo $form_data_brique[_DATE];?>">
				<input type="button" value="selection" onclick="displayDatePicker('date', false, 'dmy', '.');"></td-->
			</tr>
		<?php } //?>
		<!-- demi-jour am/pm -->
		<tr>
			<td>Demi-journée : </td>
			<td>
				<select name="demi_jour">
					<option value="am" <?php if ($demi_jour == 'am') echo 'selected="selected"'?>>matin</option>
					<option value="pm" <?php if ($demi_jour == 'pm') echo 'selected="selected"'?>>après-midi</option>
				</select>
			</td>
		</tr>
		<!-- fréquence (toutes les ... semaines) -->
		<?php if ($habituelle == true) {?>
			<tr>
				<td>Fréquence : </td>
				<td><input type="text" name="frequence" value="<?php echo $form_data_brique[Brique::_FREQUENCE]?>"></td>
			</tr>
		<?php }?>
		<!-- type brique -->
		<tr>
			<td>Type de brique : </td>
			<td>
				<select name="type_brique">
					<option value="0" disabled="disabled">Sélectionner le type de brique...</option>
					<?php foreach ($type_brique_manager->getAllTypeBriques() as $type_brique) { ?>
						<option value="<?php $type_brique->getId()?>" style="background-color: <?php echo $type_brique->getCouleur()?>;"
								<?php if ($type_brique->getId() == $brique->getType_brique()) echo 'selected="selected"'?>>
								<?php echo $type_brique->getDesignation()?></option>
					<?php }?>
				</select>
			</td>
		</tr>
		<!-- Durée -->
		<tr>
			<td>Durée [h] : </td>
			<td><input type="text" name="duree" value="<?php echo $brique->getDuree()?>"></td>
		</tr>
		<!-- Texte -->
		<tr>
			<td>Texte : </td>
			<td><input type="text" name="texte" value="<?php echo $brique->getTexte()?>"></td>
		</tr>
		<!-- Boutons -->
		<tr>
			<td><input type="submit" name="<?php echo ($habituelle == 1) ? "retour_semaine" : "retour_mois";?>" value="Retour"></td>
			<td><input type="submit" name="enregistrer" value="Enregistrer"></td>
		</tr>
		<tr>
			<td><input type="submit" name="supprimer" value="Supprimer"></td> 	
			<td><input type="submit" name="creer_habituelle" value="Créer brique habituelle"></td>
		</tr>
		</table>
	</form>
</body>
