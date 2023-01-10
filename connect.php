<?php
//$dsn='mysql:host=pierreemad9310466.ipagemysql.com;dbname=workspace;';
//$user='joe';
//$pass='Joe1234.';

$dsn='mysql:host=localhost;dbname=workspace;';
$user='root';
$pass='';


$option=array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
try{
    $con=new PDO($dsn , $user , $pass , $option);
    $con->setAttribute(PDO::ATTR_ERRMODE ,PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
    echo "faild" .$e->getMessage();
}?>


