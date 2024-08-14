<?php
<<<<<<< HEAD
include_once "config.php";
=======
  $serverName = '192.168.254.198';
  $connectionInfo = array("Database"=>"LIGPRINT", "UID"=>"ligprint", "PWD"=>"ligprint@2023", "CharacterSet"=>"UTF-8");
  $conn = sqlsrv_connect($serverName, $connectionInfo);
  if($conn){
    echo "";
  }else{
    echo "falha na conex�o";
    die( print_r(sqlsrv_errors(), true));
  }
>>>>>>> 72bea7b8c8aecc059349a50d67d59aea1b6cd73a

$serverName = '192.168.254.198';
$connectionInfo = array("Database" => "LIGPRINT", "UID" => "ligprint", "PWD" => "ligprint@2023", "CharacterSet" => "UTF-8");
$conn = sqlsrv_connect($serverName, $connectionInfo);
if ($conn) {
  echo "";
} else {
  echo "falha na conex�o";
  die(print_r(sqlsrv_errors(), true));
}

?>