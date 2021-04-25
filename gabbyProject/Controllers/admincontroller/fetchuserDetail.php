<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: *');


  
$sign = 'getUser';
// connect to db
include_once('../../db.php');


if(isset($_GET['getUser']))
{ $sign = $_GET['getUser'];}


if($sign == 'getUser'){ 

 $id =   @$_POST['id'];

$res =  $db->query("SELECT * FROM `user` WHERE `Id` = '$id' ");

$numRow = $res->num_rows;

  if($numRow == 1){
	$data = [];

	while($row = $res->fetch_assoc()){
		array_push($data,$row);
	}

	  echo json_encode($data);

  }


   

     
 
 } 


?>