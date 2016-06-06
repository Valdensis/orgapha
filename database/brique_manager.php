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

require_once '../database/mysqlconnection.php';
require_once '../business/class.Brique.php';
require_once 'type_brique_manager.php';

class BriqueManager {
	
	private $connection;
	
	// Nom de la table
	const TABLE_NAME = 'brique';
	
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
		if ($id < 1) return null;
		
		$query = "SELECT * FROM brique WHERE " . self::ID . " = '$id'";
		$result = $this->connection->selectDB($query);
		$row = $result->fetch();
		if (!$row) return null;
		
		$retour = self::rowToBrique($row);
		
		return $retour;
	}
	
	/**
	 * @param int $id_utilisateur
	 * @param string $demi_jour
	 * @param unknown $jour
	 * @return NULL|Brique
	 */
	public function getBriqueHabituelle($id_utilisateur, $demi_jour, $jour ) {
		// Tests
		if ($id_utilisateur < 1) return null;
		if ($demi_jour != Brique::MATIN && $demi_jour != Brique::APRES_MIDI) return null;
		// TODO if ($jour)
		
		$query = "SELECT * FROM brique WHERE " . self::UTILISATEUR . " = '$id_utilisateur' AND " .
				self::DEMI_JOUR . " = '$demi_jour' AND " .
				self::JOUR_SEMAINE . " = '$jour' AND " .
				self::HABITUELLE . " = 1";					// pour avoir que les briques habituelles
		$result = $this->connection->selectDB($query);
		$row = $result->fetch();
		if (!$row) return null;
		
		$retour = self::rowToBrique($row);
		
		return $retour;
	}
	
	
	/**
	 * @param int $id_utilisateur
	 * @param string $demi_jour
	 * @param unknown $date
	 * @return NULL|Brique
	 */
	public function getBriqueUnique($id_utilisateur, $demi_jour, $date) {
		// Tests
		if ($id_utilisateur < 1) return null;
		if ($demi_jour != Brique::MATIN && $demi_jour != Brique::APRES_MIDI) return null;
		// TODO if ($date)
		if (!checkdate(substr($date, 5, 2), substr($date, 8, 2), substr($date, 0, 4))) {
			echo "$date n'est pas une date aaaa-mm-jj";
			return null;
		}
		
		$query = "SELECT * FROM brique WHERE " . self::UTILISATEUR . " = '$id_utilisateur' AND " .
				self::DEMI_JOUR . " = '$demi_jour' AND " .
				self::DATE_BRIQUE . " = '$date' AND " .
				self::HABITUELLE . " = 0";					// pour avoir les briques non-habituelles
		$result = $this->connection->selectDB($query);
		$row = $result->fetch();
		if (!$row) return null;
		
		$retour = self::rowToBrique($row);
		
		return $retour;
	}
	/*
	 * CREATE, UPDATE, DELETE
	 */
	/**
	 * CREATE
	 * @param Brique $brique
	 * @return NULL|string|number
	 */
	public function createBrique(Brique $brique) {
		if ($brique == null) return null;
		
		$query = "INSERT INTO brique (" . 	self::DEMI_JOUR . ", " . 	self::HABITUELLE . ", " . self::JOUR_SEMAINE . ", " . self::FREQUENCE . ", " . self::DATE_BRIQUE . ", " . self::TEXTE . ", " . self::TEXTE . ", " . self::DUREE . ", " . self::UTILISATEUR . ", " . self::TYPE_BRIQUE . ")
									VALUES ('" . $brique->getDemi_jour() . "', '" . $brique->isHabituelle() . "', '" . $brique->getJour_semaine() . "', '" . $brique->getFrequence() . "', '" . $brique->getDate() . "', '" . $brique->getTexte() . "', '" . $brique->getDuree() . "', '" . $brique->getUtilisateur() . "', '" . $brique->getType_brique() . "');";
		
		return $this->connection->executeQuery($query);
	}
	
	/**
	 * UPDATE
	 * @param Brique $brique
	 * @return string|number
	 */
	public function updateBrique(Brique $brique) {
		$query = "UPDATE brique
					SET " . self::DEMI_JOUR . " = " . $brique->getDemi_jour() . ", " .
							self::HABITUELLE . " = " . $brique->isHabituelle() . ", " .
							self::JOUR_SEMAINE . " = " . $brique->getJour_semaine() . ", " .
							self::FREQUENCE . " = " . $brique->getFrequence() . ", " .
							self::DATE_BRIQUE . " = " . $brique->getDate() . ", " .
							self::TEXTE . " = " . $brique->getTexte() . ", " .
							self::DUREE . " = " . $brique->getDuree() . ", " .
							self::UTILISATEUR . " = " . $brique->getDuree() . ", " .
							self::TYPE_BRIQUE . " = " . $brique->getType_brique() . 
					" WHERE " . self::ID . " = " . $brique->getId() . ";";
		
		return $this->connection->executeQuery($query);
	}
	
	/**
	 * DELETE
	 * @param Brique $brique
	 * @return string|number
	 */
	public function deleteBrique(Brique $brique) {
		$query = "DELETE brique WHERE " . self::ID . " = " . $brique->getId();
		
		return $this->connection->executeQuery($query);
	}
	
	/*
	 * AUTRES FONCTIONS
	 */
	public function getColor(Brique $brique) {
		$type_brique_manager = new TypeBriqueManager();
		$type_brique = $type_brique_manager->getTypeBrique($brique->getType_brique());
		if($type_brique == null) return "#000000";
		return $type_brique->getCouleur();
	}
}
