<?php
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: *');


        include_once('../../db.php');

        $sign = 'getLecturers';

        
        if(isset($_GET['lecturer'])){
            $sign = $_GET['lecturer'];
        }


      //this block of code handles the name display 		
		if($sign == 'getUser'){
			$id = $_POST['id'];
	
			 $sql = $db->query("SELECT * FROM `user` WHERE `Id`='$id' ");
			 $numRows = $sql->num_rows;
			  $data = [];
			  if($numRows>0){
				  while ($row = $sql->fetch_assoc()) {
					 array_push($data,$row);
				  }
	
				  echo json_encode($data);
			  }
		  }
	
	 

   // this block of codes executes the enrollment program
    if($sign == 'execute'){
        exec('c:/Fingerprint/enroll.jar');
    }
      // executes the attendance program
    if($sign == 'attendance'){
        exec('c:/Fingerprint/attendance.jar');
    }

     //get all the courses 
    if($sign == 'getcourse'){

        $levelId = $_POST['lvl'];
        $deptId = $_POST['dept'];

        
        
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

 

    if($sign == 'submit'){
        
                    
            $data = file_get_contents("php://input");
            $Obj = json_decode($data);

            
            $name = $Obj->name;
            $regnum = $Obj->regNum;
            $lvlId = $Obj->level;
            $deptId = $Obj->dept;

    


  
     
       //check if students and regNum already exists

       $checkIfStudentExists =  $db->query("SELECT * FROM `students` WHERE `name`='$name' AND `regNum` = '$regnum' ");
        $numRows = $checkIfStudentExists->num_rows;

         if($numRows > 0){
             echo 401;
            }else{
             $res = $db->query("INSERT INTO `students`( `name`, `regNum`, `dept_Id`, `level_Id`, `date_created`) 
             VALUES ('$name','$regnum','$deptId','$lvlId',NOW())");

               if($res){
                   $lastId = $db->insert_id;

                
 
                   foreach ($Obj->course as $key => $value) {
                     $res1 = $db->query("INSERT INTO `student_course`( `student_Id`, `courseId`, `date_created`) VALUES ($lastId,$value,NOW())");
                       if($res1){
                           echo 200;
                       
                   }
               } 
            }
        }
           
       
    }

      if($sign == 'getStudent')
      {
           $res = $db->query("SELECT department.*,department.Id AS dip,students.*, students.Id AS stid, level.*,level.Id AS lid FROM students JOIN department ON dept_Id = department.Id JOIN level ON level_Id = level.Id ");
           $numRows = $res->num_rows;
            
             if($numRows > 0){
                 while ($row = $res->fetch_assoc()) {
                     $Id = $row['stid'];
                     $name = $row['name'];
                     $regNum = $row['regNum'];
                     $level =  $row['level'];
                     $dept =   $row['dept'];

                    $data [] = array('id'=>$Id, 'name'=>$name, 'regNum' =>$regNum, 'level'=>$level,'dept'=>$dept);
                 }

                  echo json_encode($data);
             }
              

      }






?>