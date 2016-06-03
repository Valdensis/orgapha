<?php
/************************************************************\
 *
 * File				type_brique_manager.php
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
require_once '../business/class.Brique.php';
require_once '../business/class.Type_brique.php';

class TypeBriqueManager {
	
	private $connection;
	
	// Nom de la table
	const TABLE_NAME = 'type_brique';
	
	// Noms des champs dans la BD
	const ID = "ty_id";
	const DESIGNATION = "ty_designation";
	const COULEUR = "ty_couleur";
	const PAYE = "ty_paye";
	const PRESENT = "ty_present";
	const DISPONIBLE = "ty_disponible";
	const TEXTE = "ty_texte";
	
	public function __construct() {
		$this->connection = new MySqlConnection();
	}
	
	/*
	 * SELECTs
	 */
	/**
	 * Transforme une ligne de la réponse au SELECT en objet Type_brique
	 * @param unknown $row
	 * @return Type_brique
	 */
	private function rowToTypeBrique($row) {
		return new Type_brique($row[self::ID], $row[self::DESIGNATION], 
				$row[self::COULEUR], $row[self::PAYE], $row[self::PRESENT], 
				$row[self::DISPONIBLE], $row[self::TEXTE]);
	}
	
	/**
	 * @param int $id
	 * @return NULL|Type_brique
	 */
	public function getTypeBrique($id) {
		if ($id < 1) return null;
		
		$query = "SELECT * FROM type_brique WHERE " . self::ID . " = '$id'";
		$result = $this->connection->selectDB($query);
		$row = $result->fetch();
		if (!$row) return null;
		
		$retour = self::rowToTypeBrique($row);
		
		return $retour;
	}
	/*
	 * CREATE, UPDATE, DELETE
	 */
	// TODO
}