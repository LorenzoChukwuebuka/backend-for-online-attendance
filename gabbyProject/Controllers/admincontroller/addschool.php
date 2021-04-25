<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: *');

$sign = 'add';
include_once('../../db.php');

//@add schools

if(isset($_GET['add']))
{ $sign = $_GET['add'];}

if($sign == 'add'){
  $school = $_POST['school'];

  $res1 = $db->query("SELECT * FROM `school` WHERE `school` = '$school'");
   $numRows = $res1->num_rows;

   if($numRows == 0 ){
    $res = $db->query("INSERT INTO `school` (`school`) VALUES ('$school')");

    if($res){
        echo 200;
    }else{
        echo 501;
    }
    
   }else {
       echo 404;
   }

 
  

}



















?>