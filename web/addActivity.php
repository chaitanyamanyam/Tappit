<?php
session_start();
// Check, if user is already login, then jump to secured page
if (!isset($_SESSION['sess_username'])) {
header('Location: index.php');
}

if (isset($_SESSION['sess_username'])) {
$user1 = $_SESSION['sess_username'];
    //echo $user1;
}

$db = pg_connect(getenv('DATABASE_URL')) or die("Unable to connect to postgre");
 //$db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$db){
     // echo "Error : Unable to open database\n";
   } else {
      //echo "Opened database successfully\n";
   }



   
if(isset($_POST["activityname"]) && strlen($_POST["activityname"])>0) 
{   //check $_POST["content_txt"] is not empty

    //sanitize post value, PHP filter FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH Strip tags, encode special characters.
    //$contentToSave = filter_var($_POST["project_name"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 
    
    $activityname=$_POST["activityname"];
    //echo $activityname;
    
    $sqlcheck = "select count(*) from category_details where username='".$user1."' and category='".$activityname."'";
    
     $ret = pg_query($db, $sqlcheck);
    if(!$ret){
    //echo pg_last_error($db);
    exit;
    }
        while($row = pg_fetch_row($ret)){
        $projectExists= $row[0] ;
    }
      
    
    if ($projectExists>0)
           
       {
            header('Content-Type: application/json');
            echo json_encode(array("num1"=>1));
           exit();
           
       } else {   
    
    // Insert sanitize string in record
    $activityInsert= "insert into category_details values ('".$user1."','".$activityname."')";
    
    
     $retactivity = pg_query($db, $activityInsert);
        if(!$retactivity){
        //echo pg_last_error($db);
        exit();
        }
    
    
    //$insert_row = $mysqli->query("INSERT INTO add_delete_record(content) VALUES('".$contentToSave."')");
    
    if($retactivity)
    {
        //echo "success";        
        echo json_encode(array("num1"=>2));
            //echo json_encode($brr);
        exit();
    }else{
        
        //header('HTTP/1.1 500 '.mysql_error()); //display sql errors.. must not output sql errors in live mode.
        header('HTTP/1.1 500 Looks like mysql error, could not insert record!');
        exit();
    }

}
    
}
else
{
    //Output error
    header('HTTP/1.1 500 Error occurred, Could not process request!');
    exit();
}

pg_close($db);

?>