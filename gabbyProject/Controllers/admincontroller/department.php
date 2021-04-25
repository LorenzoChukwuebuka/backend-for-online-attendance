<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: *');

include_once('../../db.php');

$sign = 'fetchschools';

if(isset($_GET['Dept']))
{ $sign = $_GET['Dept'];}




// fetch the relevant school data

if($sign == 'fetchschools'){
    $res = $db->query("SELECT * FROM `school`");
    $numRows = $res->num_rows;

    if($numRows > 0){
       $data = [];
       while($rw = $res->fetch_assoc()){
           array_push($data,$rw);
       } 
        echo json_encode($data);
    }
}



// create

if($sign == 'create'){
    $dept = $_POST['dept'];
    $schId = $_POST['schId'];

    $res1 = $db->query("SELECT * FROM `department` WHERE `dept` = '$dept'");
    $numRows = $res1->num_rows;

     if($numRows == 0){
        $res = $db->query("INSERT INTO `department`(`dept`, `school_Id`) VALUES ('$dept','$schId')");
        if($res){
           echo 200;
          }else{
          echo 500;
         }

    }else {
        echo 404;
    }

    
}



// read 

 if($sign == 'read'){
     $res = $db->query("SELECT school.*,department.* FROM department JOIN school ON department.school_Id = school.Id ");
     $numRows = $res->num_rows;

     if($numRows > 0){
    
        $data = [];
        
        while($rw = $res->fetch_assoc()){
            array_push($data,$rw);
         }
         echo json_encode($data);
     }
 }



// update 

if($sign == 'update'){
    $id = $_POST['Id'];
    $schId = $_POST['schId'];
    $dept = $_POST['dept'];

    $res = $db->query("UPDATE `department` SET `dept`='$dept',`school_Id`='$schId' WHERE `Id` = '$id'");
      if($res){
          echo 200;
      }else{
          echo 500;
      }
}



//delete

if($sign == 'delete'){
    $id = $_POST['Id'];
    $res = $db->query("DELETE FROM `department` WHERE `Id` = '$id'");
    if($res){
        echo 200;
    }else{
        echo 500;
    }
}

?>