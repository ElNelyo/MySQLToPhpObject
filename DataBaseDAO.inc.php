<?php 
//Acces to data
require_once 'DAO.inc.php' ; 
require_once 'DataBase.inc.php' ; 
class DataBaseDAO extends DAO{ 


public function get_Tables($bd){ 
$req = $this->prepare("SHOW tables from $bd "); 
$req->execute() ;
return $this->cursorToArrayNonObject($req); 
} 



public function get_Columns($table){ 
$req = $this->prepare("SHOW COLUMNS FROM $table"); 
$req->execute();
return $this->cursorToArrayNonObject($req); 
} 

public function get_Primary($table){
$req = $this->prepare(" SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'");
$req->execute();
return $this->cursorToArrayNonObject($req);


}

}