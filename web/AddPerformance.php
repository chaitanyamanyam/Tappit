<?php
session_start();

// Check, if user is already login, then jump to secured page
if (!isset($_SESSION['sess_username'])) {
header('Location: index.php');
}

if (isset($_SESSION['sess_username'])) {
$user1 = $_SESSION['sess_username'];
    echo $user1;
}

$db = pg_connect(getenv('DATABASE_URL')) or die("Unable to connect to postgre");
 //$db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$db){
      echo "Error : Unable to open database\n";
   } else {
      echo "Opened database successfully\n";
   }

date_default_timezone_set('America/New_York');
$date = date('Y-m-d H:i:s', time());

echo $date;

if(isset($_POST["projectvalue"]) && strlen($_POST["projectvalue"])>0) 
{   //check $_POST["content_txt"] is not empty
    
    $projectname=$_POST["projectvalue"];
    echo $projectname;
    $activity =$_POST["activityvalue"];
    echo $activity;
    echo $_POST["optradio"];
    if(isset($_POST["estimatedtime"]) && strlen($_POST["estimatedtime"])>0) 
    {
        $esttime =$_POST["estimatedtime"];
    } else
    {
        $esttime=0;
    }
    echo $esttime;
    echo $_POST["status"];
    
    if($_POST["optradio"]=="past"){
        
    $fromdate =$_POST["fromdate"];
    echo "from;".$fromdate;
    $date1 = new DateTime($fromdate);
    $new_date_format = $date1->format('Y-m-d H:i:s');
    $fromdateMillisecs= strtotime($new_date_format) *1000;
    echo "frommilli;".$fromdateMillisecs;
     
    echo $new_date_format;
    
     $todate =$_POST["todate"];
    echo $todate;
    $date2= new DateTime($todate);
    $new_to_format = $date2->format('Y-m-d H:i:s');
    $todateMillisecs= strtotime($new_to_format) *1000;
    echo $todateMillisecs;
        
    $sqlInsert="insert into performance_details2 values ('".$user1."','".$projectname."','".$activity."',".$fromdateMillisecs.",".$todateMillisecs.",".$esttime.")"; 
    echo $sqlInsert;        
        
        
    } elseif ($_POST["optradio"]=="present" && $_POST["status"]=="start") {
        
        $fromdate =$_POST["fromdate"];
        echo $fromdate;
        
        
    $sqlInsert="insert into performance_details2 values ('".$user1."','".$projectname."','".$activity."',".$fromdate.",".$fromdate.",".$esttime.")"; 
        echo $sqlInsert;
    }
    elseif ($_POST["optradio"]=="present" && $_POST["status"]=="end") { 
         $fromdate =$_POST["fromdate"];
        echo $fromdate;
        $todate =$_POST["todate"];
        echo $todate;
        
        $sqlInsert= "update performance_details2 set stop_task =".$todate." where username='".$user1."' and project_name = '".$projectname."' and               category = '".$activity."' and start_task = ".$fromdate ;
    }
    
    else {
        
    }
    
    
     $ret = pg_query($db, $sqlInsert);
        if(!$ret){
        echo pg_last_error($db);
        }
        
    
    //$insert_row = $mysqli->query("INSERT INTO add_delete_record(content) VALUES('".$contentToSave."')");
    
    if($ret)
    {
        echo "success";        
       // echo json_encode(array("num1"=>1,"num2"=>2));
            //echo json_encode($brr);
       // exit();
    }else{
        
        //header('HTTP/1.1 500 '.mysql_error()); //display sql errors.. must not output sql errors in live mode.
        header('HTTP/1.1 500 Looks like mysql error, could not insert record!');
        exit();
    }
    
    
}

else
{
    //Output error
    header('HTTP/1.1 500 Error occurred, Could not process request!');
    //exit();
}    


pg_close($db);

?>