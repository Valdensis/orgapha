<?php
/************************************************************\
 *
 * File				senregistrer.php
 *
 * Language			PHP
 *
 * Author			David Mack
 * Creation			18 juin 2016
 * modification 
 *
 * Project			orgapha
 * 
 * Cette page permet à un utilisateur inscrit de se connecter
 *
 \************************************************************/
?>
<form method="post" action="/../orgapha/backoffice/back.senregistrer.php">
	<table>
		<tr>
			<th>Utilisateur :</th>
			<td><input type="text" name="nom_utilisateur"></td>
		</tr>
		<tr>
			<th>Mot de passe :</th>
			<td><input type="password" name="passe"></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" name="senregistrer"
				value="S'enregistrer"></td>
		</tr>
	</table>
</form>