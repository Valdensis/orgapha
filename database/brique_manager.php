<?php
/************************************************************\
 *
 * File				brique_manager.php
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

require_once 'database/mysqlconnection.php';
require_once 'business/class.Brique.php';

class BriqueManager {
	
	private $connection;
	
	// Noms des champs dans la BD
	const ID = "br_id";
	const DEMI_JOUR = 'br_demi_jour';
	const HABITUELLE = 'br_habituelle';
	const JOUR_SEMAINE = 'br_jour_semaine';
	const FREQUENCE = 'br_frequence';
	const DATE_BRIQUE = 'br_date';
	const TEXTE = 'br_texte';
	const DUREE = 'br_duree';
	const UTILISATEUR = 'br_utilisateur';
	const TYPE_BRIQUE = 'br_type_brique';
	
	public function __construct() {
		$this->connection = new MySqlConnection();
	}
	 
	/*
	 * SELECTs
	 */
	/**
	 * Transforme une ligne de la réponse au SELECT en objet Brique
	 * @param unknown $row
	 * @return Brique
	 */
	private function rowToBrique($row) {
		return new Brique($row[$this::ID], $row[$this::DEMI_JOUR], 
				$row[$this::HABITUELLE], $row[$this::JOUR_SEMAINE], 
				$row[$this::FREQUENCE], $row[$this::DATE_BRIQUE], 
				$row[$this::TEXTE], $row[$this::DUREE], 
				$row[$this::UTILISATEUR], $row[$this::TYPE_BRIQUE]);
	}
	
	/**
	 * @param int $id
	 * @return NULL|Brique
	 */
	public function getBrique($id) {
		if ($id < 1) return NULL;
		
		$query = "SELECT * FROM brique WHERE br_id = '$id'";
		$result = $this->connection->selectDB($query);
		$row = $result->fetch();
		if (!row) return null;
		
		$retour = self::rowToBrique($row);
		
		return $retour;
	}
	
	public function getBriqueHabituelle($id_utilisateur, $demi_jour, $jour ) {
		// TODO 
	}
	
	public function getBriqueUnique($id_utilisateur, $demi_jour, $date) {
		// TODO
	}
	
}
