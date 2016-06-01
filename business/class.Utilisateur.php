<?php
/************************************************************\
 *
 * File				class.Utilisateur.php
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
class Utilisateur {
	
	private $id;
	private $prenom;
	private $nom;
	private $surnom;
	private $initiales;
	private $passe;
	private $email;
	private $date_inscription;
	private $date_entree;
	private $date_sortie;
	private $actif;
	private $role;
	private $type_collaborateur;
	private $type_salaire;
	
	// rôles
	const _ADMIN = 1;		// administrateur, peut tout faire
	const _CHEF = 2;		// chef, peut donner les congés
	const _UTILIS = 3;		// utilisateur, peut modifier une case et demander congé
	const _CONSULT = 4;		// consultation, peut juste voir le planning et demander congés
	
	// types salaires
	const _MENSUEL = 'M';
	const _HORAIRE = 'H';
	const _HEBDOMADAIRE = 'S';
	
	// constructeur
	function __construct($id, $prenom, $nom, $surnom, $initiales, $passe, 
						$email, $date_inscription, $date_entree, $date_sortie, 
						$actif, $role, $type_collaborateur, $type_salaire = self::_MENSUEL) {
		$this->setId($id);
		$this->setPrenom($prenom);
		$this->setNom($nom);
		$this->setPrenom($prenom);
		$this->setSurnom($surnom);
		$this->setInitiales($initiales);
		$this->setPasse($passe);
		$this->setEmail($email);
		$this->setDate_inscription($date_inscription);
		$this->setDate_entree($date_entree);
		$this->setDate_sortie($date_sortie);
		$this->setActif($actif);
		$this->setRole($role);
		$this->setType_collaborateur($type_collaborateur);
		$this->setType_salaire($type_salaire);
	}
	
	
	// getters & setters
	public function getType_salaire()
	{
		return $this->type_salaire;
	}
	
	public function setType_salaire($type_salaire)
	{
		$this->type_salaire = $type_salaire;
	}
	
	public function getType_collaborateur() 
	{
	  return $this->type_collaborateur;
	}
	
	public function setType_collaborateur($type_collaborateur) 
	{
	  $this->type_collaborateur = $type_collaborateur;
	}    
	public function getRole() 
	{
	  return $this->role;
	}
	
	public function setRole($role) 
	{
	  $this->role = $role;
	}    
	public function isActif() 
	{
	  return $this->actif;
	}
	
	public function setActif($value) 
	{
	  $this->actif = $value;
	}    
	public function getDate_sortie() 
	{
	  return $this->date_sortie;
	}
	
	public function setDate_sortie($date_sortie) 
	{
	  $this->date_sortie = $date_sortie;
	}    
	public function getDate_entree() 
	{
	  return $this->date_entree;
	}
	
	public function setDate_entree($date_entree) 
	{
	  $this->date_entree = $date_entree;
	}    
	public function getDate_inscription() 
	{
	  return $this->date_inscription;
	}
	
	public function setDate_inscription($date_inscription) 
	{
	  $this->date_inscription = $date_inscription;
	}    
	public function getEmail() 
	{
	  return $this->email;
	}
	
	public function setEmail($email) 
	{
	  $this->email = $email;
	}    
	public function getPasse() 
	{
	  return $this->passe;
	}
	
	public function setPasse($passe) 
	{
	  $this->passe = $passe;
	}    
	public function getInitiales() 
	{
	  return $this->initiales;
	}
	
	public function setInitiales($initiales) 
	{
	  $this->initiales = $initiales;
	}    
	public function getSurnom() 
	{
	  return $this->surnom;
	}
	
	public function setSurnom($surnom) 
	{
	  $this->surnom = $surnom;
	}    
	public function getNom() 
	{
	  return $this->nom;
	}
	
	public function setNom($nom) 
	{
	  $this->nom = $nom;
	}
	public function getId() 
	{
	  return $this->id;
	}
	
	public function setId($id) 
	{
	  $this->id = $id;
	}
	
	    
	public function getPrenom() 
	{
	  return $this->prenom;
	}
	
	public function setPrenom($prenom) 
	{
	  $this->prenom = $prenom;
	}
}