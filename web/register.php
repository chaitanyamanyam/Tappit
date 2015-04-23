
<?php
ob_start();
ini_set('display_errors', 'off');
error_reporting(E_ALL);

if($_POST){
 $register_db = pg_connect(getenv('DATABASE_URL')) or die("Unable to connect to postgre");
 //$db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$register_db){
     // echo "Error : Unable to open database\n";
   } else {
     // echo "Opened database successfully\n";
   }

  
  $uname=$_POST['uname'];
  $fname=$_POST['firstname'];
  $lname=$_POST['lname'];
  $pwd=$_POST['pwd'];
  $yob=$_POST['yob'];
  $cor=$_POST['cor'];
  
    $emailid=$_POST['emailid'];

  if($uname!='' && $fname && $lname && $pwd!='' && $yob && $cor!=''  )
  { 
  
  $sqlcheck="SELECT count(*) from register_page where username= '".$uname."'"; 
   $ret = pg_query($register_db, $sqlcheck);
        
    while($row =pg_fetch_row($ret))
    {
        $returned=$row[0];
    }
      if ($returned==0)

      {
        $sqlin="INSERT INTO register_page (username,firstname,lastname,dob,emailid,cor,password)
           values ('".$uname."','".$fname."','".$lname."','".$yob."','".$emailid."','".$cor."','".$pwd."')"; 
     
        $ret2 = pg_query($register_db, $sqlin);
        if(!$ret2){
        echo pg_last_error($db);
        }  

        echo"<p align='center'><b>Account Created </br></b></p>";
        echo"<p align='center'><a href='index.php' align='center'> LOGIN PAGE</a></p>";
        exit();
      }
      else{

        echo "<p align='center'><b>Enter a new username </br>which is unique</b></p></br>";
      }
    
  }
  else{
    echo "<p align='center'><b>Enter data properly </b></p></br>";
  }
}

ob_end_flush();

?>


<html>
<head>
  <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="http://dc-js.github.io/dc.js/css/dc.css"/>
      <link href="/css/sticky-footer.css" rel="stylesheet">
      </head>
<body>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
     <script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
 <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script type="text/javascript" >   
    $(function() {
         $( "#calendar" ).datepicker();   
    }); 
    $(document).ready(function(){
      $("#uniquebt").click(function(){
        var txt=$("input:text[name=uname]").val();
          //alert(txt);
          if($.trim(txt) != ''){
            $.post('usernameCheck.php',{name:txt},function(data){
              alert(data);
            });
          }
      });
    });
   
</script>

<body> 
  <div class="container">
   <div class="page-header">

          <h1>TappIt <span class="glyphicon glyphicon-book" aria-hidden="true"></span></h1>
          <a href="/dialogHome.php">
            <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
            Home
          </a>
          <!-- <a href="#">
            <span class="glyphicon glyphicon-download" aria-hidden="true"></span>
            Download report
          </a> 
          <a href="/report.php">
            <span class="glyphicon glyphicon glyphicon-signal" aria-hidden="true"></span>
            View report
          </a>
          <a href="/logout.php">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            Logout
          </a> -->
        </div>

    <div style="text-align:center"> <h2>Tapp It</h2>
  <strong>Fill the details below</strong>
  <br></br>
  <form action="register.php" method="post" font color="red"> 
   <table align="center">
    <tr><td><p>Username      </td><td>  <input type="text" class="form-control" name="uname" id="uname"/> </td> <td> <input type='button' value='Unique' class="btn btn-primary" id="uniquebt" align/></p></td></tr>
   <tr><td><p>First Name  </td><td>  <input type="text" class="form-control" name="firstname" onkeypress="return checkNum();"/></p></td></tr>
   <tr><td><p>Last Name  </td><td>  <input type="text" class="form-control" name="lname" onkeypress="return checkNum();"/></p></td></tr>
   <tr><td><p>Password   </td><td>  <input type="password" class="form-control" name="pwd" /></p> </td></tr>
   <tr><td><p>Date of Birth </td><td> <input type="date" class="form-control" name="yob" id="calendar"/></p></td></tr>
  <tr><td><p>City of Residence</td><td> <input type="text" class="form-control" name="cor" onkeypress="return checkNum();"/></p> </td></tr>
   <tr><td><p>Email Id     </td><td>  <input type="text" class="form-control" name="emailid" onblur="validateEmail(this.value)"/></p> </td></tr>

   </table>
   <p><input type="submit" class="btn btn-primary" name="submit"/></p>
  <a href='index.php'>Login Page</a>


  </div>
</div>
 <script type="text/javascript">
function checkNum()
{
 
if ((event.keyCode > 64 && event.keyCode < 91) || (event.keyCode > 96 && event.keyCode < 123) || event.keyCode == 8)
   return true;
else{
  return false;
} 
}
function validateEmail(sEmail) {
  var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;

  if(!sEmail.match(reEmail)) {
    alert("Invalid email address");
    return false;
  }

  return true;}
</script>
</body>
</form>
</html>

