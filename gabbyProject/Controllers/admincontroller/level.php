<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: *');

include_once('../../db.php');

$sign = 'Add';

if(isset($_GET['Level']))
{ $sign = $_GET['Level'];}

//fetch school 
if($sign == 'fetchdept'){
    $res = $db->query("SELECT * FROM `department`");
    $numRows = $res->num_rows;

    if($numRows > 0){
       $data = [];
       while($rw = $res->fetch_assoc()){
           array_push($data,$rw);
       } 
        echo json_encode($data);
    }
}


