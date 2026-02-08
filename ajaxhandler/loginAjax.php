<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
$path=$_SERVER['DOCUMENT_ROOT'];
require_once $path."/database/database.php";
require_once $path."/database/facultyDetails.php";
$action=$_REQUEST["action"];
if(!empty($action))
{
    if($action=="verifyUser")
    {      
        //retrieve what was sent
          $un=$_POST["user_name"];
          $pw=$_POST["password"];
          //$rv=["un"=>$un,"pw"=>$pw];
          //echo json_encode($rv);
          //check if exists in database
          $dbo=new Database();
          // $createdb= new CreateTables();
          $fdo=new faculty_details();
          $rv=$fdo->verifyUser($dbo,$un,$pw);
          if($rv['status']=="ALL OK")
          {
            $_SESSION['current_user']=$rv['id'];
          }
          for($i=0;$i<100000;$i++)
          {
            for($j=0;$j<2000;$j++)
            {
              
            }
          }
          //send response
          echo json_encode($rv);
    }
    if ($action == "verifyGoogleUser") {
      // Retrieve the JWT token sent from the client
      $jwtToken = $_POST["google_token"];
  
      // Verify the token with Google's API
      $url = 'https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=' . $jwtToken;
      $response = file_get_contents($url);
      $response = json_decode($response);
  
      if ($response->email_verified) {
          // Check if the domain is srmist.edu.in
          if (strpos($response->email, '@srmist.edu.in') !== false) {
              // Check if the user exists in the database
              $dbo = new Database();
              $fdo = new faculty_details();
  
              // Pass the full response object to verifyGoogleUser
              $rv = $fdo->verifyGoogleUser($dbo, $response);
  
              if ($rv['status'] == "ALL OK") {
                  
                  $_SESSION['current_user'] = $rv['id'];
              }
  
              // Remove unnecessary loops
              // Send response back to the client
              echo json_encode($rv);
          } else {
              $rv = ["status" => "Only SRMIST.edu.in accounts are allowed."];
              echo json_encode($rv);
          }
      } else {
          $rv = ["status" => "Email not verified"];
          echo json_encode($rv);
      }
  }
}
?>