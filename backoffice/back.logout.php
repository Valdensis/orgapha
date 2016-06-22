<?php
/************************************************************\
 *
 * File				mois.php
 *
 * Language			PHP
 *
 * Author			David Mack
 * Creation			22 juin 2016
 * modification
 *
 * Project			orgapha
 *
 \************************************************************/
session_start();
unset($_SESSION['utilisateur']);
echo "<script type='text/javascript'>document.location.replace('/orgapha/pages/mois.php');</script>";