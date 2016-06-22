<?php
/************************************************************\
 *
 * File				header.inc
 *
 * Language			PHP
 *
 * Author			David Mack
 * Creation			01 juin 2016
 * modification
 *
 * Project			orgapha
 *
 \************************************************************/
if (! isset ( $_SESSION )) {
	session_start ();
}
// Vérifier si une Session est en cours avec un no d'utilisateur
if(!isset($_SESSION["utilisateur"]) OR $_SESSION["utilisateur"] == null)
{
	header ( "Location: /orgapha/pages/senregistrer.php" );
} else {
	$utilisateur = unserialize($_SESSION['utilisateur']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="/orgapha/css/style.css">
<link rel="stylesheet" type="text/css" href="/orgapha/css/datePicker.css">
<!-- script type="text/javascript">
	var this_month = 'aujourd\'hui';	// <?php echo json_encode(_CE_MOIS);?>;
	var close = 'fermer';				// <?php echo json_encode(_FERMER);?>;
	var monday = 'lundi';				// <?php echo json_encode(_JOUR_LU);?>;
	var tuesday = 'mardi';				// <?php echo json_encode(_JOUR_MA);?>;
	var wednesday = 'mercredi';			// <?php echo json_encode(_JOUR_ME);?>;
	var thursday = 'jeudi';				// <?php echo json_encode(_JOUR_JE);?>;
	var friday = 'vendredi';			// <?php echo json_encode(_JOUR_VE);?>;
	var saturday = 'samedi';			// <?php echo json_encode(_JOUR_SA);?>;
	var sunday = 'dimanche';			// <?php echo json_encode(_JOUR_DI);?>;
	var january = 'janvier'; 			// <?php echo json_encode(_JANVIER);?>;
	var february = 'février';			// <?php echo json_encode(_FEVRIER);?>;
	var march = 'mars';					// <?php echo json_encode(_MARS);?>;
	var april = 'avril'; 				// <?php echo json_encode(_AVRIL);?>;
	var may = 'mai';					// <?php echo json_encode(_MAI);?>;
	var june = 'juin';					// <?php echo json_encode(_JUIN);?>;
	var july = 'juillet';				// <?php echo json_encode(_JUILLET);?>;
	var august = 'août';				// <?php echo json_encode(_AOUT);?>;
	var september = 'septembre';		// <?php echo json_encode(_SEPTEMBRE);?>;
	var october = 'octobre';			// <?php echo json_encode(_OCTOBRE);?>;
	var november = 'novembre';			// <?php echo json_encode(_NOVEMBRE);?>;
	var december = 'décembre';			// <?php echo json_encode(_DECEMBRE);?>;
</script-->
<script type="text/javascript" src="datePicker.js" charset="UTF-8"></script>
</head>
<body>
	<div><a class="bouton" href="/orgapha/backoffice/back.logout.php">Logout</a></div>