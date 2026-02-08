<?php
$path=$_SERVER['DOCUMENT_ROOT'];
require_once $path."/database/database.php";
class faculty_details
{
    public function verifyUser($dbo,$un,$pw)
    {
        $rv=["id"=>-1,"status"=>"ERROR"];
          $c="select id,password from faculty_details where user_name=:un";
          $s=$dbo->conn->prepare($c);
          try{
             $s->execute([":un"=>$un]);
             if($s->rowCount()>0)
             {
                 $result=$s->fetchAll(PDO::FETCH_ASSOC)[0];
                 if($result['password']==$pw)
                 {
                    //all ok
                    $rv=["id"=>$result['id'],"status"=>"ALL OK"];
                 }
                 else{
                    //pw does not match
                    $rv=["id"=>$result['id'],"status"=>"Wrong password"];
                 }
             }
             else{
              //user name does not exists
              $rv=["id"=>-1,"status"=>"USER NAME DOES NOT EXISTS"];
             }
          }
          catch(PDOException $e)
          {

          }
          return $rv;
    }
    public function verifyGoogleUser($dbo, $response)
    {
        // Ensure $response is an object and has the 'email' property
        if (!isset($response->email)) {
            return ["id" => -1, "status" => "INVALID RESPONSE"];
        }
    
        $email = $response->email; // Correctly access the 'email' property
        $rv = ["id" => -1, "status" => "ERROR"];
    
        // Corrected SQL query (removed the extra comma)
        $c = "SELECT id, user_name FROM faculty_details WHERE user_name = :email";
        $s = $dbo->conn->prepare($c);
    
        try {
            // Execute the query with the email parameter
            $s->execute([":email" => $email]);
    
            // Check if any rows were returned
            if ($s->rowCount() > 0) {
                $result = $s->fetchAll(PDO::FETCH_ASSOC)[0]; // Fetch the first row
    
                // Verify the email matches
                if ($result['user_name'] === $email) {
                    // All OK
                    $rv = ["id" => $result['id'], "status" => "ALL OK"];
                } else {
                    // Email does not match (though this should not happen)
                    $rv = ["id" => $result['id'], "status" => "EMAIL MISMATCH"];
                }
            } else {
                // User does not exist
                $rv = ["id" => -1, "status" => "USER DOES NOT EXIST"];
            }
        } catch (PDOException $e) {
            // Log the exception for debugging purposes
            error_log("Database error: " . $e->getMessage());
            $rv = ["id" => -1, "status" => "DATABASE ERROR"];
        }
    
        return $rv;
    }
    public function getCoursesInASession($dbo,$sessionid,$facid)
    {
      $rv=[];
      $c="select cd.id,cd.code,cd.title from 
      course_allotment as ca,course_details as cd
      where ca.course_id=cd.id and faculty_id=:facid and session_id=
      :sessionid";
      $s=$dbo->conn->prepare($c);
      try{
        $s->execute([":facid"=>$facid,":sessionid"=>$sessionid]);
        $rv=$s->fetchAll(PDO::FETCH_ASSOC);
      }
      catch(Exception $e)
      {

      }
      return $rv;
    }
    public function getFacultyName($dbo,$facid)
    {
      $name='';
      $c="select name from faculty_details where id=:id";
          $s=$dbo->conn->prepare($c);
          try{
             $s->execute([":id"=>$facid]);
             if($s->rowCount()>0)
             {
                 $result=$s->fetchAll(PDO::FETCH_ASSOC)[0];
                 $name=$result['name'];
             }
             else{
              //user name does not exists
              $name='';
             }
          }
          catch(PDOException $e)
          {

          }
          return $name;
    }
}
?>

