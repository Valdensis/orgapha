<?php
/************************************************************\
 *
 * File				type_collaborateur_manager.php
 *
 * Language			PHP
 *
 * Author			David Mack
 * Creation			25 mai 2016
 * modification 
 *
 * Project			
 *
 \************************************************************/

require_once(dirname(__FILE__) . '/../database/mysqlconnection.php');
require_once(dirname(__FILE__) . '/../business/class.Type_collaborateur.php');

class TypeCollaborateurManager {
	
	private $connection;
	
	// Nom de la table
	const TABLE_NAME = 'type_collaborateur';
	
	// Noms des champs dans la BD
	const ID = 'co_id';
	const DESIGNATION = 'co_designation';
	const RANG = 'co_rang';
	
	// Constructeur
	public function __construct() {
		$this->connection = new MySqlConnection();
	}
	
	/*
	 * SELECTs
	 */
	/**
	 * Transforme une ligne de la réponse au SELECT en objet Type_collaborateur
	 * @param unknown $row
	 * @return Type_collaborateur
	 */
	private function rowToTypeCollaborateur($row) {
		return new Type_collaborateur($row[self::ID], $row[self::DESIGNATION], $row[self::RANG]);	
	}
	
	/**
	 * @return Type_collaborateur
	 */
	public function getAllTypeCollaborateurs() {
		$query = "SELECT * FROM " . self::TABLE_NAME . " WHERE " . self::RANG . "> 0 ORDER BY " . self::RANG . ";";
		$result = $this->connection->selectDB($query);
		
		while ($row = $result->fetch()) {
			$type_collaborateur = self::rowToTypeCollaborateur($row);
			$reponse[] = $type_collaborateur;
			unset($type_collaborateur);
		}
		return $reponse;
	}
	
	
}