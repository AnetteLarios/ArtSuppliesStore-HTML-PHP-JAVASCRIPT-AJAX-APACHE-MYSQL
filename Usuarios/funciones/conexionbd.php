<?php 
function conecta(){
  
$db_host='localhost';
$db_port='3306';
$db_name='prog_para_int';
$db_user='root';
$db_pass='';

try{
    $con = new PDO('mysql:host=' . $db_host . ';port=' .$db_port . ';dbname=' . $db_name, $db_user, $db_pass);
    return $con;
}catch (Exception $e){
  echo 'No se pudo conectar a la base de datos'.$e->getMessage();  
}
}
?>