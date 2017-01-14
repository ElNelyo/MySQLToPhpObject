<?php
include_once"function.php";
//Main Control

if(isset($_POST['load'])){

$IP = $_POST['adress'];
$PORT = $_POST['port'];
$DB = $_POST['db'];
$USER = $_POST['user'];
$PASS = $_POST['pass'];
CreateFileParamIntern($USER,$PASS,$IP,$DB);
}



if(isset($_POST['done'])){

createFolder('done');
createFolder('done/Object');
createFolder('done/DAO');


$IP = $_POST['adress'];
$PORT = $_POST['port'];
$DB = $_POST['db'];
$USER = $_POST['user'];
$PASS = $_POST['pass'];

CreateFileParam($USER,$PASS,$IP,$DB);

CreateDAO();






include_once"DataBase.inc.php";
include_once"DataBaseDAO.inc.php";





$data = new DataBaseDAO();
$tables = $data->get_Tables($DB);



createMainObject($tables,$DB);
createMainDAO($tables,$DB);


foreach ($tables as $atable) {
	$Column = new DataBaseDAO();
//print_r($Column->get_Columns($atable['Tables_in_'.$DB]));

CreateObjectTable($atable['Tables_in_'.$DB],$Column->get_Columns($atable['Tables_in_'.$DB]));
CreateDAOTable($atable['Tables_in_'.$DB],$Column->get_Columns($atable['Tables_in_'.$DB]));

}
CreateIndex($tables,$DB);



}