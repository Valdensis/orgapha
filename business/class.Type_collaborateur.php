<?php
/************************************************************\
 *
 * File				class.Type_collaborateur.php
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
class Type_collaborateur {
	private $id;
	private $designation;
	private $rang;
	
	// constructeur
	function __construct($id, $designation, $rang) {
		$this->setId($id);
		$this->setDesignation($designation);
		$this->setRang($rang);
	}
	
	// getters & setters
	public function getRang() 
	{
	  return $this->rang;
	}
	
	public function setRang($rang) 
	{
	  $this->rang = $rang;
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