<?php
/************************************************************\
 *
 * File				class.Type_brique.php
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
class Type_brique {
	private $id;
	private $designation;
	private $couleur;
	private $paye;
	private $present;
	private $disponible;
	private $texte;
	
	// constructeur
	function __construct($id, $designation, $couleur, $paye, $present, $disponible, $texte) {
		$this->setId($id);
		$this->setDesignation($designation);
		$this->setCouleur($couleur);
		$this->setPaye($paye);
		$this->setPresent($present);
		$this->setDisponible($disponible);
		$this->setTexte($texte);
	}
	
	// getters & setters
	public function getTexte() 
	{
	  return $this->texte;
	}
	
	public function setTexte($texte) 
	{
	  $this->texte = $texte;
	}    
	public function isDisponible() 
	{
	  return $this->disponible;
	}
	
	public function setDisponible($value) 
	{
	  $this->disponible = $value;
	}    
	public function isPresent() 
	{
	  return $this->present;
	}
	
	public function setPresent($value) 
	{
	  $this->present = $value;
	}
	public function isPaye() 
	{
	  return $this->paye;
	}
	
	public function setPaye($value) 
	{
	  $this->paye = $value;
	}    
	public function getCouleur() 
	{
	  return $this->couleur;
	}
	
	public function setCouleur($couleur) 
	{
	  $this->couleur = $couleur;
	}    
	public function getDesignation() 
	{
	  return $this->designation;
	}
	
	public function setDesignation($designation) 
	{
	  $this->designation = $designation;
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