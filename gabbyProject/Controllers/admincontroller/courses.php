<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: *');

include_once('../../db.php');

$sign = 'getDept';

if(isset($_GET['course']))
{
     $sign = $_GET['course'];
}

//get dept

if($sign == 'getDept'){
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

//get level 

if($sign == 'getLevel'){
    $res = $db->query("SELECT * FROM `level`");
    $numRows = $res->num_rows;

    if($numRows > 0){
       $data = [];
       while($rw = $res->fetch_assoc()){
           array_push($data,$rw);
       } 
        echo json_encode($data);
    }
}

//create course

if($sign == 'create'){
   $course_code = $_POST['courseCode'];
   $course = $_POST['course'];
   $level = $_POST['level'];
   $dept = $_POST['dept'];

   $res1 = $db->query("SELECT * FROM `course` WHERE `course_code` = '$course_code' AND `course` = '$course'");
   $numRows = $res1->num_rows;

   if($numRows == 0 ){
            $res = $db->query("INSERT INTO `course`( `course`, `course_code`, `level_Id`, `dept_id`) VALUES ('$course','$course_code','$level','$dept')");
            if($res){
                echo 200;
            }else{
                echo 500;
            }
   }else{
       echo 404;
   }

  
}

//read course 

if($sign == 'read'){
    $res = $db->query("SELECT department.*,level.*,course.* FROM course JOIN level ON course.level_Id = level.Id JOIN department ON course.dept_id = department.Id  ");
    $numRows = $res->num_rows;

    if($numRows > 0){
       $data = [];
       while($rw = $res->fetch_assoc()){
           array_push($data,$rw);
       } 
        echo json_encode($data);
    }
}

//update course 

if($sign == 'update'){
    $id = $_POST['Id'];
    $course = $_POST['course'];
    $course_code = $_POST['course_code'];
    $lvl = $_POST['level'];
    $dept = $_POST['dept'];

    $res = $db->query("UPDATE `course` SET `course`='$course',`course_code`='$course_code',`level_Id` = '$lvl',`dept_id`='$dept' WHERE `Id` = '$id'");
      if($res){
          echo 200;
      }else{
          echo 500;
      }
}

if($sign == 'delete'){
    $id = $_POST['Id'];
    $res = $db->query("DELETE FROM `course` WHERE `Id` = '$id'");
    if($res){
        echo 200;
    }else{
        echo 500;
    }
}




























?>