<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: *');


//@view schools

include_once('../../db.php');

$sign = 'fetchschools';

if(isset($_GET['fetchschools']))
{ $sign = $_GET['fetchschools'];}

if($sign == 'fetchschools'){
    $res = $db->query("SELECT * FROM `school`");
    $numRows = $res->num_rows;
      
     if($numRows > 0){
         $data = [];
         while($row = $res->fetch_assoc()){
            array_push($data,$row);
  
         }
  
         echo json_encode($data);
     }
  }
 

  ?>