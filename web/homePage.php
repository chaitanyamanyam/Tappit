<?php
session_start();
$_SESSION['sess_username'] ="asishc";
$user=$_SESSION['sess_username'];
echo $_SESSION['sess_username'];


$db = pg_connect(getenv('DATABASE_URL')) or die("Unable to connect to postgre");
 //$db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$db){
      echo "Error : Unable to open database\n";
   } else {
      echo "Opened database successfully\n";
   }

   $sql ="select project_name from project_details where username='".$user."'";

    $sql_activity="select category from category_details where username ='".$user."'";

    /* $ret = pg_query($db, $sql);
    if(!$ret){
    echo pg_last_error($db);
    exit;
    }
        while($row = pg_fetch_row($ret)){
        echo   $row[0] ;
    }
       */                                         
                                            
   


?>

<!doctype html>
<html class="no-js">
    <head>
        
    <meta charset="utf-8">
    <title>TappIt</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="http://dc-js.github.io/dc.js/css/dc.css"/>
    <link href="/css/sticky-footer.css" rel="stylesheet">
        
    <script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
    </head>
        <body> 
              
        <div class= "container">
            <div class="page-header">

				<h1>TappIt <span class="glyphicon glyphicon-book" aria-hidden="true"></span></h1>
				<a href="/homePage.php">
					<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
					Home
				</a>
				<a href="#">
					<span class="glyphicon glyphicon-download" aria-hidden="true"></span>
					Download report
				</a>
				<a href="/report.html">
					<span class="glyphicon glyphicon glyphicon-signal" aria-hidden="true"></span>
					View report
				</a>
				<a href="/login.html">
					<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
					Logout
				</a>
			</div>
            
            <div class="row centered-form" id="tappit">
                <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                    <div class="panel-body">
                        <form  action="AddPerformance.php" role="form" method="post">
                            <div class="row" >
                                <div class ="form-group">
                                    <div class="radio-inline">
                                        <label class="radio-inline"><input type="radio" id="optradio" name="optradio" value="present">Log current work </input>
                                        </label>
                                        </div>
                                    <div class="radio-inline">
                                        <label class="radio-inline"><input type="radio" id="optradio" name="optradio" value="past">Log past work</label>
                                        </div>
                                </div> 

                            </div>   
                            
                                <div class ="row">
                                    <div class="col-xs-12 col-sm-6 col-md-6">
                                        <div class='form-group' id='projectname'>
                                            <select class="form-control" name="projectvalue" id="projectvalue">
                                                <option disabled selected>select a project</option>                                            
                                                <?php 
                                                $ret = pg_query($db, $sql);
                                                if(!$ret){
                                                echo pg_last_error($db);
                                                exit;
                                                }
                                                while($row = pg_fetch_row($ret)){
                                                echo "<option >" .$row[0]."</option>"; 
                                        
                                            }
                                                
                                                ?>
                                            </select>   
                                        </div>
                                    </div>
                                        <div class="col-xs-6 col-sm-3 col-md-3">
                                            <div class="form-control">
                                                <span ><span class="glyphicon glyphicon-plus" title="Add Project" id="addproject">AddProject</span>
                                                </span>
                                            </div>    
                                        </div>                                    
                                </div>
                        
                        <div class = "row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class='form-group' id='activity'>                              
                                        <select class="form-control" name="activityvalue" id="activityvalue">
                                            <option disabled selected>select an Activity</option>                                            
                                            <?php 
                                                $ret_activity = pg_query($db, $sql_activity);
                                                if(!$ret_activity){
                                                echo pg_last_error($db);
                                                exit;
                                                }
                                            while($row_activity = pg_fetch_row($ret_activity)){
                                                echo "<option>" .$row_activity[0]."</option>"; 
                                    
                                            }
                                                
                                            ?>
                                        </select>   
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3 col-md-3">
                                    <div class="form-control">
                                        <span ><span class="glyphicon glyphicon-plus" title="Add Activity" id="addactivity">AddActivity</span>
                                        </span>
                                    </div>    
                            </div>                                    
                        </div>
                    
                        <div  class ="form-group" id="esttime">
                            <select class="form-control" name="estimatedtime" id="estimatedtime" placeholder="Estimated Time">
                                <option disabled selected>Estimated Time</option>
                                <option value="15">15 mins</option>
                                <option value="30">30 mins</option>
                                <option value="45">45 mins</option>
                                <option value="60">1 hour</option>
                            </select>
                        
                        </div>

                
                        <div class="row" id ="datepick">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <div class='input-group date' id='datetimepicker9'>
                                        <input type='text' class="form-control" name="fromdate" id="fromdate" placeholder="From" readonly />
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>   
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <div class='input-group date' id='datetimepicker10'>
                                        <input type='text' class="form-control" name="todate" id="todate" placeholder="To" readonly />
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>                                   
                           </div>
                        </div>
                        <div class="row">
                                    <button type="submit" class="btn btn-default">Start</button> 
                                    <input type="reset" class="btn btn-default" value="Reset"/><br>
                        </div>
                        <div  class="row">
                            
                        <div id="clock-action-button">
					   <svg id="stopwatch" width="100%" height="60%">
					  <circle cx="0" cy="0" r="150" fill="transparent" stroke="steelblue" stroke-width="3"></circle>
					  <text id="time" x="0" y="0" 
					        font-family="AvenirLTStd-Light" 
					        font-size="30"
					        fill="#e58757">00:00:00
					  </text>
					  <text id="timer-action" x="0" y="0" 
					        font-family="AvenirLTStd-Light" 
					        font-size="10"
					        fill="#e58757">Start</text>
                            </svg>
					   <div id="submitted-alert" class="alert alert-success" role="alert" style="opacity:0;">
						<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
						Your work has been successfully logged
					   </div>
				        </div>
                        
                        
                        </div>
                        
                        
                    </form>
                </div>
            </div>
        </div> 
    </div>
    
            
<div class="container">           
    <div id="d1">
        <form role="form"  id="formproject">    
            <div  id='h1'>
             <input type="text" id="projecttitle" name="projecttitle" class="form-control" placeholder="Project Name"/>
                <span id="err"></span>
                <textarea class="form-control" rows="5" id="description" name="description" placeholder="Project Description"></textarea>
                </div>    
                <div>    
                <button id="projectsubmit"  class="btn btn-default">Add Project</button>
                <button id="cancelproject" class="btn btn-default">Cancel</button> 
                
                </div>
            
            </form>
             
            </div>
    </div>
            
            
<div class="container">           
    <div id="d2">
        <form role="form"  id="formactivity" >    
            <div  id='h1'>
             <input type="text" id="activityname" name="activityname" class="form-control" placeholder="Activity Name"/>
                <span id="err1"></span>
                <br>
            </div>    
                <div>    
                <button id="activitysubmit"  class="btn btn-default">Add Activity</button>
                <button id="cancelactivity" class="btn btn-default">Cancel</button> 
                
                </div>
            
            </form>
             
            </div>
    </div>   
    
    <div class="footer">
			<p class="muted credit"><p>© We are the best group. 2014</p></p>
		</div>
            
                
            
            
     <script type="text/javascript">
         
         $("#clock-action-button").click(function (e){
             
             alert("stopwatch");
             
               });
         
              
        $(document).ready(function() {
            
             $("#projectsubmit").click(function (e) {
                e.preventDefault();
            if($("#projecttitle").val()==='')
            {
                alert("Please enter some text!");
                return false;
            }
                            
            //var myData = 'project_name='+ $("#projecttitle").val()+'&project_description='+ $("#description").val(); //build a post data structure
            jQuery.ajax({
            type:"POST", // HTTP method POST or GET
            url: "addProject.php", //Where to make Ajax calls
            dataType:"json", // Data type, HTML, json etc.
            data:$("#formproject").serialize(), //Form variables
            success:function(response){
                alert("success");
                alert(response.num1);
                if (response.num1===1){
                 alert("status");
                    $("#err").show();
                 $('#err').html("<p>Project already exists</p>");   
                }
                else 
                {
                var temp = $('#projecttitle').val();

                    // Create New Option.
                    var newOption = $('<option>');
                    newOption.text(temp);

                    // Append that to the DropDownList.
                $('#projectvalue').append(newOption);
                    
                $('#projecttitle').val('');
                $('#description').val('');
                $('#err').html("");    
                $('#tappit').show(); 
                $('#d1').hide();
                }
            },
            error:function (xhr, ajaxOptions, thrownError){
                
                $('#tappit').show(); 
                $('#d1').hide();
                alert(thrownError);
            }
            });
    });
            
             $("#activitysubmit").click(function (e) {
                e.preventDefault();
            if($("#activityname").val()==='')
            {
                alert("Please enter some text!");
                return false;
            }
                            
            //var myData = 'project_name='+ $("#projecttitle").val()+'&project_description='+ $("#description").val(); //build a post data structure
            jQuery.ajax({
            type:"POST", // HTTP method POST or GET
            url: "addActivity.php", //Where to make Ajax calls
            dataType:"json", // Data type, HTML, json etc.
            data:$("#formactivity").serialize(), //Form variables
            success:function(response){
                alert("success");
                //alert(response.num1);
                if (response.num1===1){
                 alert("status");
                $("#err1").show();    
                 $('#err1').html("<p>Activity already exists</p>");   
                }
                else 
                {
                    var temp1 = $('#activityname').val();

                    // Create New Option.
                    var newOption1 = $('<option>');
                    newOption1.text(temp1);

                    // Append that to the DropDownList.
                $('#activityvalue').append(newOption1);    
                    
                $('#activityname').val('');  
                $('#err').html("");    
                $('#tappit').show(); 
                $('#d2').hide();
                }
            },
            error:function (xhr, ajaxOptions, thrownError){
                
                $('#tappit').show(); 
                $('#d2').hide();
                alert(thrownError);
            }
            });
    });


              $(function(){
                   $('#d1').hide();
                  $('#d2').hide();
            $('#addproject').click(function(){
                $('#tappit').hide(); 
                $('#d1').show(); 
            });
            $('#cancelproject').click(function(){
                $('#tappit').show(); 
                $('#d1').hide();
            });
            $('#addactivity').click(function(){
                $('#tappit').hide(); 
                $('#d2').show(); 
            });
            $('#cancelactivity').click(function(){
                $('#tappit').show(); 
                $('#d2').hide();
            });
            $("#projecttitle").click(function() {
            $("#err").hide();
            });
            $("#activityname").click(function() {
            $("#err1").hide();
            });      
                  
                               
        });
            
            
    $(function(){        
    $('#esttime').hide();
    $('#datepick').hide();
  
    $('input[type="radio"]').click(function() {
       if($(this).attr('value') == 'present') {
            $('#esttime').show();
           $('#datepick').hide();
            
        }

       else {
            $('#esttime').hide();  
           $('#datepick').show();
       }
   });
      
});
   

        
        $(function () {
            $('#datetimepicker9').datetimepicker();
            $('#datetimepicker10').datetimepicker();
            $("#datetimepicker9").on("dp.change",function (e) {
               $('#datetimepicker10').data("DateTimePicker").setMinDate(e.date);
            });
            $("#datetimepicker10").on("dp.change",function (e) {
               $('#datetimepicker9').data("DateTimePicker").setMaxDate(e.date);
            });
            
        
        });
         
    });        
          
           
       
        </script>
    
        <script type="text/javascript" src="http://dc-js.github.io/dc.js/js/d3.js"></script>
		<script type="text/javascript" src="http://dc-js.github.io/dc.js/js/crossfilter.js"></script>
		<script type="text/javascript" src="http://dc-js.github.io/dc.js/js/dc.js"></script>
		<script type="text/javascript" src="http://dc-js.github.io/dc.js/js/colorbrewer.js"></script>
    
    
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <script type="text/javascript" src="js/moment.js"></script>
        <script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>
        <script type="text/javascript" src="stopwatch.js"></script>

  

    </body>


</html>

<?php
 pg_close($db);

?>