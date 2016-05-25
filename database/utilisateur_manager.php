<?php
/************************************************************\
 *
 * File				utilisateur_manager.php
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
require_once '../database/mysqlconnection.php';
require_once '../business/class.Utilisateur.php';

class UtilisateurManager {
	
	private $connection;
	
	// Nom de la table
	const TABLE_NAME = 'utilisateur';
	
	// Noms des champs dans la BD
	const ID = 'ut_id';
	const PRENOM = 'ut_prenom';
	const NOM = 'ut_nom';
	const SURNOM = 'ut_surnom';
	const INITIALES = 'ut_initiales';
	const PASSE = 'ut_passe';
	const EMAIL = 'ut_email';
	const DATE_INSCRIPTION = 'ut_date_inscription';
	const DATE_ENTREE = 'ut_date_entree';
	const DATE_SORTIE = 'ut_date_sortie';
	const ACTIF = 'ut_actif';
	const ROLE = 'ut_role';
	const TYPE_COLLABORATEUR = 'ut_type_collaborateur';
	
	// CONSTRUCTEUR
	public function __construct() {
		$this->connection = new MySqlConnection();
	}
	
	/*
	 * SELECTs
	 */
	private function rowToUtilisateur($row) {
		return new Utilisateur($row[self::ID], $row[self::PRENOM], 
				$row[self::NOM], $row[self::SURNOM], $row[self::INITIALES], 
				$row[self::PASSE], $row[self::EMAIL], $row[self::DATE_INSCRIPTION], 
				$row[self::DATE_ENTREE], $row[self::DATE_SORTIE], $row[self::ACTIF], 
				$row[self::ROLE], $row[self::TYPE_COLLABORATEUR]);
	}
	
	/**
	 * @param int $id
	 * @return NULL|Utilisateur
	 */
	public function getUtilisateur(int $id) {
		if ($id < 1) return null;
		
		$query = "SELECT * FROM brique WHERE " . self::ID . " = '$id';";
		$result = $this->connection->selectDB($query);
		$row = $result->fetch();
		if (!row) return null;
		
		$retour = self::rowToUtilisateur($row);
		
		return $retour;
	}
	
	/**
	 * @param boolean $actif
	 * @return Utilisateur
	 */
	public function getAllUtilisateurs(boolean $actif) {
		$actifs = $actif ? " WHERE " . self::ACTIF . " = true" : "";
		$query = "SELCT * FROM ad" . $actifs . ";";
		$result = $this->connection->selectDB($query);
		while ($row = $result->fetch()) {
			$utilisateur = self::rowToUtilisateur($row);
			$response[] = $utilisateur;
			unset($utilisateur);
		}
		return $response;
	}
	/*
	 * CREATE, UPDATE, INSERT
	 */
	// TODO
}