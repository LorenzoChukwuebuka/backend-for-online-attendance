<?php
 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: *'); 

   if(isset($_GET['logUser'])){
       $log = $_GET['logUser'];
   }

   //connect to db
   include_once('../db.php');

   $error = 0;
   $pass = "";

   $log = "login";

    if($log == 'login'){

        if($_POST['username'] && !empty('username')){
            $user = $_POST['username'];
        }else{
            $error = 1;
        }

        if($_POST['password'] && !empty('password')){
            $pass = $_POST['password'];
        }else{
            $error = 2;
        }

          

      if($error ==  0){

          
         $res = $db->query("SELECT * FROM `user` WHERE `username`='$user' AND `password`='$pass' ");
         $numRows = $res->num_rows; 

            if($numRows === 1){
                $rw = $res->fetch_assoc();
                $data = [];

                array_push($data,$rw);

                echo json_encode($data);

          
            }else{
                echo 500;
            } 

      } 

 
 
















    }




