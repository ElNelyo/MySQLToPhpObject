

<?php
include_once"DataBaseDAO.inc.php";
//Function used for creating files 

function CreateFileParam($user,$pass,$ip,$db){

	$name = fopen('done/Param.inc.php','w+');
	fputs($name,'
<?php
class Param{


public static $login="'.$user.'";
public static $mdp="'.$pass.'";
public static $dsn = \'mysql:host='.$ip.';dbname='.$db.';charset=utf8\'; }
?>');
	if($name==false)
die("Fail to create the file : ".$name);


}

function CreateFileParamIntern($user,$pass,$ip,$db){

	$name = fopen('Param.inc.php','w+');
	fputs($name,'
<?php
class Param{


public static $login="'.$user.'";
public static $mdp="'.$pass.'";
public static $dsn = \'mysql:host='.$ip.';dbname='.$db.';charset=utf8\'; }
?>');
	if($name==false)
die("Fail to create the file : ".$name);


}



function CreateDAO(){

	$name = fopen('done/DAO.inc.php','w+');
	fputs($name,'
<?php
include_once "Param.inc.php";
require_once \'Object/mainObject.inc.php\'; 
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
}');
	if($name==false)
die("Fail to create the file : ".$name);


}

function Setter($nameColumns){
	return $Setter = "public function set_".$nameColumns."(\$x){
		\$this->_".$nameColumns."=\$x;} \n";
}
function Getter($nameColumns){
	return $getter = "public function get_".$nameColumns."(){
		return \$this->_".$nameColumns.";} \n";
}



function CreateObjectTable($nameClass,$columns){
			$attribute ="";
			$setter = "";
			$getter ="";
			
		foreach($columns as $acolumn){
		 $attribute= $attribute ."private \$_".$acolumn['Field']."; \n ";
		 $setter = $setter.Setter($acolumn['Field']);
		 $getter = $getter.Getter($acolumn['Field']);
			
		}
			$name = fopen('done/Object/'.$nameClass.'.inc.php','w+');
			fputs($name,'<?php class '.$nameClass.'{'."\n".$attribute."\n".$getter. "\n".$setter.'}'
		);
			if($name==false)
		die("Fail to create the file : ".$name);

}







function GetDataSelect($nameClass , $columns){
	$attribute ="";
	$req = " public function get_".$nameClass."(){ \n \$req = \$this-> prepare(\"SELECT";
	for ($i=0; $i < count($columns) ; $i++) { 
		if($i==0){
			$attribute= $attribute." \$this->_".$columns[$i]['Field'];
		}else{
			$attribute= $attribute.", \$this->_".$columns[$i]['Field'];
			}
	}
	$req = $req.$attribute;
	$req = $req." FROM $nameClass \" ); \n \$req->execute(); \n return \$this->cursorToObjectArray(\$req);\n}\n";
	return $req;
}

function GetDataSelectByPK($nameClass,$columns){
$DataBaseDAO = new DataBaseDAO();
$PK=$DataBaseDAO->get_Primary($nameClass);


	$parameters="";
	$attribute ="";
	$req = " public function get_".$nameClass."_By_PK(){ \n \$req = \$this-> prepare(\"SELECT";
	for ($i=0; $i < count($columns) ; $i++) { 
		if($i==0){
			$attribute= $attribute." \$this->_".$columns[$i]['Field'];
		}else{
			$attribute= $attribute.", \$this->_".$columns[$i]['Field'];
			}
	}
	$req = $req." FROM $nameClass ";
	
	for ($i=0; $i<count($PK) ; $i++) { 
		$parameters = "\$req->BindParam(\":X_".$PK[$i]['Column_name']."\",$".$PK[$i]['Column_name'].");\n";
		if($i==0){
			$attribute= $attribute." \$this->_".$PK[$i]['Column_name']." = :X_".$PK[$i]['Column_name'];
		}else{
			$attribute= $attribute." AND \$this->_".$PK[$i]['Column_name']."= :X_".$PK[$i]['Column_name'];
			}
	}

	$req = $req." WHERE ".$attribute."\");\n";
	$req= $req.$parameters;
	$req = $req."\$req->exectute(); \n return \$this->cursorToObject(\$req);\n}\n";



	return $req;
}




function CreateDAOTable($nameClass,$columns){
	$attribute="";
	$dao ="";
	$pk="";
		foreach($columns as $acolumn){
		$attribute = $attribute."private \$_".$acolumn['Field']." = \"".$acolumn['Field']." as _".$acolumn['Field']."\";\n";
	$dao = GetDataSelect($nameClass,$columns);
	$pk = GetDataSelectByPK($nameClass,$columns);
	}
	


	$name = fopen('done/DAO/'.$nameClass.'DAO.inc.php','w+');
		fputs($name,"<?php include_once '../DAO.inc.php'; \n"."\n".' class '.$nameClass.'DAO extends DAO {'."\n".$attribute."\n".$dao."\n".$pk."}");
			if($name==false)
		die("Fail to create the file : ".$name);
	
}






function createMainObject($columns,$db){

	$attribute = "";
	$name = fopen('done/Object/mainObject.inc.php','w+');

	for ($i=0; $i <count($columns) ; $i++) { 
		$attribute =$attribute ."include_once'".$columns[$i]['Tables_in_'.$db].".inc.php';\n";
	}
	$req="<?php ".$attribute."?>";
	fputs($name,$req);

}
function createMainDAO($columns,$db){

	$attribute = "";
	$name = fopen('done/DAO/mainDAO.inc.php','w+');

	for ($i=0; $i <count($columns) ; $i++) { 
		$attribute =$attribute ."require_once'".$columns[$i]['Tables_in_'.$db]."DAO.inc.php';\n";
	}
	$req="<?php ".$attribute."?>";
	fputs($name,$req);

}


function CreateIndex($columns,$db){
	$attribute="";
	$printed="";
	$name = fopen('done/index.php','w+');
	$put ="<?php include_once 'DAO/mainDAO.inc.php';  \n include_once 'Object/mainObject.inc.php';\n ?>

		<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"utf-8\" />
        <title>DataToObject Generator </title>
    </head>

    <body>
    <h1>Result generate by the script</h1>
    <?php ";
  	$end = "?></body>
</html>";

    for ($i=0; $i <count($columns) ; $i++) { 

    	$attribute = $attribute."\$Example".$columns[$i]['Tables_in_'.$db]." = new ".$columns[$i]['Tables_in_'.$db]."DAO();\n";
    	$printed = $printed."print_r(\$Example".$columns[$i]['Tables_in_'.$db]."->get_".$columns[$i]['Tables_in_'.$db]."());\n";

    }








	fputs($name,$put.$attribute.$printed.$end);

}



function createFolder($name){
$folder = $name;
if(!is_dir($folder)){
   mkdir($folder);
}

}