<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: *');
header('Content-Type:application/json');


  
$sign = 'getDept';
// connect to db
include_once('../../db.php');


if(isset($_GET['lecturer']))
{ $sign = $_GET['lecturer'];}

if($sign == 'getSchool'){
	
	

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

if($sign === 'getDept' ){
	 $Id = $_POST['Id'];


    $res = $db->query("SELECT school.*, department.* FROM department JOIN school ON department.school_Id = school.Id WHERE school.Id = '$Id'");
     $numRows = $res->num_rows;

     if($numRows > 0){
        $data = [];

        while($row = $res->fetch_assoc()){
            array_push($data,$row);
        }
       echo json_encode($data);
     }
}

if($sign === 'getLevel' ){
    $res = $db->query("SELECT * FROM `level`");
     $numRows = $res->num_rows;

     if($numRows > 0){
        $data = [];

        while($row = $res->fetch_assoc()){
            array_push($data,$row);
        }
       echo json_encode($data);
     }
}

if($sign === 'getCourse' ){

  $data = file_get_contents("php://input");
  $Obj = json_decode($data);

  /* $levelId = $_POST['level'];
   $deptId = $_POST['dept']; */

   $levelId = $Obj->level;
   $deptId= $Obj->dept;

      

       $res = $db->query("SELECT course.*,course.Id AS cid, level.*,department.* FROM course JOIN level ON level.Id = course.level_Id JOIN department ON department.Id = course.dept_id WHERE course.level_Id = '$levelId' AND course.dept_id = '$deptId' ");

       $numRows = $res->num_rows;
   
       if($numRows > 0){
         $data = [];
   
           while($row = $res->fetch_assoc()){
               $id = $row['cid'];
               $course = $row['course'];
               $course_code = $row['course_code'];
               $data[] = array("cid"=>$id,"course"=>$course,'courseCode'=>$course_code);
           }
           echo json_encode($data);
       } 
     

  

 

   
}

if($sign === 'create'){

    
//accept json and convert to json in php
   $data = file_get_contents("php://input");
   $Obj = json_decode($data);

  // $newjsonstring = json_encode($phpObj);
  // header('Content-Type:application/json'); 
    //generate password for lecturer... 

    $len = 8;
    $dat = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $pass = substr(str_shuffle($dat), 0, $len); 
    

    $name = $Obj->name;

 

     
    $checkifUserExists = $db->query("SELECT * FROM `user` WHERE `username` = '$name'");
    $numRow = $checkifUserExists->num_rows;
     
    if($numRow == 0){
      $res = $db->query("INSERT INTO `user`( `username`, `password`, `type`) VALUES ('$name','$pass','1')");

	    if($res){
			$lecturerId = $db->insert_id;

			foreach ($Obj->course as $key => $value) {
				$res1 = $db->query("INSERT INTO `lecturer_course`(`lecturerId`, `courseId_1`, `time_created`) VALUES ('$lecturerId','$value',NOW())");
				
				if($res1){
					echo $pass;
				}
			}

			 
	   

		}

    }else{
		echo 500;
	}

  
   
 }

 if($sign == "fetchLecturer"){
	  $res = $db->query("SELECT course.*, user.*, user.Id as UID, lecturer_course.*,lecturer_course.Id AS lid FROM lecturer_course JOIN user ON lecturerId = user.Id JOIN course ON courseId_1 = course.Id");
    $numRow =  $res->num_rows;

     if($numRow > 0 ){
       // $data = [];
		 
		 while($row = $res->fetch_assoc()){
     $Id = $row['lid']; 
		 $name = $row['username'];
		 $course = $row['course'];
		 $course_code = $row['course_code'];
		 $uid = $row['UID'];
		 

		 $data[] = array("lid"=>$Id,"course"=>$course,'courseCode'=>$course_code,"name"=>$name,"lecturerId"=>$uid);
		 
		 }

		 echo json_encode($data);
  
	 
     }
 }

 if($sign == "delete"){
	 $Id = $_POST['Id'];
	 $res = $db->query("DELETE FROM `lecturer_course` WHERE `Id` = '$Id'");
	 if($res){
		 echo 200;
	 }
 }

 if($sign == "update"){
			
	 $Id = $_POST['Id'];
	 $name = $_POST['name'];
	 $course = $_POST['course'];
     $userId = $_POST['lecturerId'];

	  $res = $db->query("UPDATE `user` SET `username` = '$name' WHERE `Id` = '$userId' ");
	    if($res){
			echo 200;
			$res1 = $db->query("UPDATE `lecturer_course` SET `course` = '$course' WHERE `Id` = '$Id'");

			if($res1){
				echo 201;
			}
		}
	 


 }

