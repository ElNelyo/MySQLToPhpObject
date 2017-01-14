<?php
include_once "Param.inc.php";
//Data to Object

abstract class DAO extends PDO{
		public function __construct(){
		parent::__construct(Param::$dsn, Param::$login, Param::$mdp);
		//$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
	}

	protected function cursorToObjectArray($curseur){
		$tab = $curseur->fetchAll(PDO::FETCH_CLASS, substr(get_class($this),0,-3));
		return $tab;
	}
	
	protected function cursorToObject($curseur){
		$curseur->setFetchMode(PDO::FETCH_CLASS, substr(get_class($this),0,-3));
		return $curseur->fetch(PDO::FETCH_CLASS);
	}
	protected function cursorToArrayNonObject($curseur){
		$tab = $curseur->fetchAll(PDO::FETCH_ASSOC);
		return $tab;
	}
}