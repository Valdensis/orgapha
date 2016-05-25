<?php
/************************************************************\
 *
 * File				class.Brique.php
 *
 * Language			PHP
 *
 * Author			David Mack
 * Creation			24 mai 2016
 * modification 
 *
 * Project			orgapha
 *
 \************************************************************/
class Brique {
	private $id;
	private $demi_jour;
	private $habituelle;
	private $jour_semaine;
	private $frequence;
	private $date;
	private $texte;
	private $duree;
	private $utilisateur;
	private $type_brique;
	
	// Constantes
	const MATIN = 'am';
	const APRES_MIDI = 'pm';
	// TODO const valeurs de $jour_semaine : string ou int...
	
	// constructeur
	function __construct($id, $demi_jour, $habituelle, $jour_semaine, $frequence, 
						 $date, $texte, $duree, $utilisateur, $type_brique) {
		$this->setId($id);
		$this->setDemi_jour($demi_jour);
		$this->setHabituelle($habituelle);
		$this->setJour_semaine($jour_semaine);
		$this->setFrequence($frequence);
		$this->setDate($date);
		$this->setTexte($texte);
		$this->setDuree($duree);
		$this->setUtilisateur($utilisateur);
		$this->setType_brique($type_brique);
	}
	
	// getters & setters
	public function getType_brique() 
	{
	  return $this->type_brique;
	}
	
	public function setType_brique($type_brique) 
	{
	  $this->type_brique = $type_brique;
	}    
	public function getUtilisateur() 
	{
	  return $this->utilisateur;
	}
	
	public function setUtilisateur($utilisateur) 
	{
	  $this->utilisateur = $utilisateur;
	}    
	public function getDuree() 
	{
	  return $this->duree;
	}
	
	public function setDuree($duree) 
	{
	  $this->duree = $duree;
	}    
	public function getTexte() 
	{
	  return $this->texte;
	}
	
	public function setTexte($texte) 
	{
	  $this->texte = $texte;
	}    
	public function getDate() 
	{
	  return $this->date;
	}
	
	public function setDate($date) 
	{
	  $this->date = $date;
	}    
	public function getFrequence() 
	{
	  return $this->frequence;
	}
	
	public function setFrequence($frequence) 
	{
	  $this->frequence = $frequence;
	}    
	public function getJour_semaine() 
	{
	  return $this->jour_semaine;
	}
	
	public function setJour_semaine($jour_semaine) 
	{
	  $this->jour_semaine = $jour_semaine;
	}    
	public function isHabituelle() 
	{
	  return $this->habituelle;
	}
	
	public function setHabituelle($valeur) 
	{
	  $this->habituelle = $valeur;
	}    
	public function getDemi_jour() 
	{
	  return $this->demi_jour;
	}
	
	public function setDemi_jour($demi_jour) 
	{
	  $this->demi_jour = $demi_jour;
	}
	public function getId() 
	{
	  return $this->id;
	}
	
	public function setId($id) 
	{
	  $this->id = $id;
	}
}