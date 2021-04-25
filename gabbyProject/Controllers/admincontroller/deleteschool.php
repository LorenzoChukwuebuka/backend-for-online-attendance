<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: *');


include_once('../../db.php');

$sign = 'deleteschool';

if(isset($_GET['deleteschool']))
{ $sign = $_GET['deleteschool'];}

if($sign == 'deleteschool'){
 $id = $_POST['Id'];
 $res = $db->query(" DELETE FROM `school` WHERE `Id` = '$id' ");
   if($res){
       echo 200;
   }else{
       echo 500;
   }
}

//update school 

if($sign == 'updateSchool'){
   $id = $_POST['Id'];
   $school = $_POST['school'];
   $res = $db->query("UPDATE `school` SET `school` = '$school' WHERE `Id` = '$id' ");

     if($res){
         echo 200;
     }else{
         echo 500;
     }
}




?>