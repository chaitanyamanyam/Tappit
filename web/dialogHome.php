<?php

//include this to get username and logged in session
session_start();

// Check, if user is already login, then jump to secured page
if (!isset($_SESSION['sess_username'])) {
header('Location: index.php');
}
$user = $_SESSION['sess_username'];

//till here


$db = pg_connect(getenv('DATABASE_URL')) or die("Unable to connect to postgre");
 //$db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$db){
     // echo "Error : Unable to open database\n";
   } else {
      //echo "Opened database successfully\n";
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
				<a href="/dialogHome.php">
					<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
					Home
				</a>
				<!-- <a href="#">
					<span class="glyphicon glyphicon-download" aria-hidden="true"></span>
					Download report
				</a> -->
				<a href="/report.php">
					<span class="glyphicon glyphicon glyphicon-signal" aria-hidden="true"></span>
					View report
				</a>
				<a href="/logout.php">
					<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
					Logout
				</a>
			</div>
            
            <div class="row centered-form" id="tappit">
                <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                    <div class="panel-body" style="text-align:center";>
                        <form id="logform"  role="form" action="AddPerformance.php" method="post" >
                            <div class="row" >
                                <div class ="form-group">
                                    <div class="radio-inline">
                                        <label class="radio-inline"><input type="radio" id="optradio" name="optradio" value="present" onchange="check_inputs()" checked>Log current work </input>
                                        </label>
                                        </div>
                                    <div class="radio-inline">
                                        <label class="radio-inline"><input type="radio" id="optradio" name="optradio" value="past" onchange="check_inputs()">Log past work</label>
                                        </div>
                                </div> 

                            </div>   
                            
                                <div class ="row">
                                    <div class="col-xs-12 col-sm-6 col-md-6">
                                        <div class='form-group' id='projectname'>
                                            <select class="form-control" name="projectvalue" id="projectvalue" onchange="check_inputs()">
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
                                            <div class="btn-group">                                                                        
                                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#basicModal">
                                                <span ><span class="glyphicon glyphicon-plus" title="Add Project" id="addproject">AddProject</span>
                                                </span></a>
                                            </div>    
                                        </div>                                    
                                </div>
                        
                        <div class = "row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class='form-group' id='activity'>                              
                                        <select class="form-control" name="activityvalue" id="activityvalue" onchange="check_inputs()">
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
                                <div class="btn-group"> 
                                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#smallModal">
                                                <span ><span class="glyphicon glyphicon-plus" title="Add Activity" id="addactivity">AddActivity</span>
                                                </span></a>
                                </div>
                            </div>                                    
                        </div>
                        
                    <div class="row">                                            
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div  class ="form-group" id="esttime">
                            <select class="form-control" name="estimatedtime" id="estimatedtime" placeholder="Estimated Time" onchange="check_inputs()">
                                <option disabled selected>Estimated Time</option>
                                <option value="15">15 mins</option>
                                <option value="30">30 mins</option>
                                <option value="45">45 mins</option>
                                <option value="60">1 hour</option>
                                <option value="90">1 hour 30 mins</option>
                                <option value="120">2 hours</option>
                                <option value="150">2 hours 30 mins</option>
                                <option value="180">3 hours</option>
                                <option value="240">4 hours</option>
                            </select>
                            <input type="hidden" id="status" name="status"></input>
                        
                        </div>
                    </div>  
                </div>        

                        <div id ="datepick">
                        <div class="row" >
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <div class='input-group date' id='datetimepicker9'>
                                        <input type='text' class="form-control" name="fromdate" id="fromdate" placeholder="From" readonly />
                                        <span class="input-group-addon"><a><span class="glyphicon glyphicon-calendar" onclick="check_past_inputs()"></span></a>
                                        </span>
                                    </div>
                                </div>
                            </div>   
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <div class='input-group date' id='datetimepicker10'>
                                        <input type='text' class="form-control" name="todate" onchange="check_past_inputs()" id="todate" placeholder="To" readonly />
                                        <span class="input-group-addon"><a><span class="glyphicon glyphicon-calendar" onclick="check_past_inputs()"></span></a>
                                        </span>
                                    </div>
                                </div>                                   
                           </div>
                        </div>
                        
                        <div class="row">
                                    <button id="logsubmit" class="btn btn-primary" disabled="disabled">Submit</button> 
                                    <input type="reset" id ="logformReset"class="btn btn-danger" value="Reset"/><br>
                        </div>
                        </div>    
                        
                        <div  class="row">
                            
                        <div id="clock-action-button">
                            <div>
        					   <svg id="stopwatch" width="100%" height="60%" style="height: 350px;">
            					  <circle cx="0"  cy="0" r="150" fill="transparent" stroke="grey" stroke-width="3"></circle>
            					  <text id="time" x="0" y="0" 
            					        font-family="AvenirLTStd-Light" 
            					        font-size="30"
            					        fill="grey">00:00:00
            					  </text>
            					  <text id="timer-action" x="0" y="0" 
            					        font-family="AvenirLTStd-Light" 
            					        font-size="10"
            					        fill="grey">Start</text>
                                </svg>
                            </div>
    					   <div id="submitted-alert" class="alert alert-success" role="alert" style="opacity:0;">
    						<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
    						Your work has been successfully logged
    					   </div>
                           <div id="estimated-alert" class="alert alert-info" role="alert" style="opacity:0;">
                               <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                               You have underestimated the time you would need for this activity. Check your performance in the report section.
                           </div>
				        </div>
                        
                        </div> 
                        
                    </form>
                </div>
            </div>
        </div> 
    </div>
    
          
 <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">TappIt <span class="glyphicon glyphicon-book" aria-hidden="true"></h4>
          </div>
          <div class="modal-body">
            <div> 
                <form role="form"  id="formproject">    
                <div  id='h1' class= "form-group">
                <input type="text" id="projecttitle" name="projecttitle" class="form-control" placeholder="Project Name"/>
                </div>
                <div  class= "form-group">   
                <span id="err" style="color:red;font-weight:bold"></span>
                <textarea class="form-control" rows="5" id="description" name="description" placeholder="Project Description"></textarea>
                </div>    
                </form>
             
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" id="cancelproject" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="projectsubmit">Add Project</button>
          </div>
        </div>
      </div>
    </div>

    
  
<div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">TappIt <span class="glyphicon glyphicon-book" aria-hidden="true"></h4>
          </div>
          <div class="modal-body">
            <div >
                <form role="form"  id="formactivity" >    
                <div  id='h1' class="form-group">
                <input type="text" id="activityname" name="activityname" class="form-control" placeholder="Activity Name"/>
                <span id="err1" style="color:red;font-weight:bold"></span>
                <br>
                </div>    
                <div>  
                </div>
            
            </form>
             
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="cancelactivity" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" id="activitysubmit"  class="btn btn-primary">Add Activity</button>
          </div>
        </div>
      </div>
    </div>    
            
            
<div class="footer">
			<p class="muted credit"><p>©TappIt. Improving your performance. 2014</p></p>
		</div>
            
                
            
            
     <script type="text/javascript">
         
         $("#logsubmit").click(function (e){
             e.preventDefault();
             //alert("past");
             //$('#logform').submit();
                          
            jQuery.ajax({
            type:"POST", // HTTP method POST or GET
            url: "AddPerformance.php", //Where to make Ajax calls
            dataType:"text", // Data type, HTML, json etc.
            data:$("#logform").serialize(), //Form variables
            success:function(response){
               // alert("success");
                $('#logform')[0].reset();
                $('#datepick').hide();
                d3.select("#submitted-alert").transition().style("opacity","1").duration(2000);
                setTimeout(function(){
                    d3.select("#submitted-alert").transition().style("opacity","0").duration(2000);
                },4000);
               
            },
            error:function (xhr, ajaxOptions, thrownError){
                
                alert(thrownError);
            }
            });
             
             });
         
         function logPresentWork(status){
             
         //alert("stopwatch");
           //  alert(status);
             $("#status").val(status);
              if  (status==="end"){
             //$("#logform").submit();
                  $('#logform').find(':input:disabled').prop('disabled',false);
              }             
             jQuery.ajax({
            type:"POST", // HTTP method POST or GET
            url: "AddPerformance.php", //Where to make Ajax calls
            dataType:"text", // Data type, HTML, json etc.
            data:$("#logform").serialize(), //Form variables
            success:function(response){
                //alert("success");
                
                if (status==="start"){
                    
                   $('#logform').find(':input:not(:disabled)').prop('disabled',true);
                    
                                    }
                else if  (status==="end")
                {
                    
                    $('#logform')[0].reset();
                     //$('#esttime').hide();
                }
            },
            error:function (xhr, ajaxOptions, thrownError){
                
                alert(thrownError);
            }
            });
                  
                   
         }
         
        
         
              
        $(document).ready(function() {
            
             $("#projectsubmit").click(function (e) {
                e.preventDefault();
            if($("#projecttitle").val()==='')
            {
                //alert("Please enter some text!");
                $("#err").show(); 
                 $('#err').html("<p>Project name is required</p>");
                return false;
            }
                            
            //var myData = 'project_name='+ $("#projecttitle").val()+'&project_description='+ $("#description").val(); //build a post data structure
            jQuery.ajax({
            type:"POST", // HTTP method POST or GET
            url: "addProject.php", //Where to make Ajax calls
            dataType:"json", // Data type, HTML, json etc.
            data:$("#formproject").serialize(), //Form variables
            success:function(response){
                //alert("success");
                //alert(response.num1);
                if (response.num1===1){
                // alert("status");
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
                //$('#tappit').show(); 
                $('#basicModal').modal('hide');
                }
            },
            error:function (xhr, ajaxOptions, thrownError){
                
                alert(thrownError);
            }
            });
    });
            
             $("#activitysubmit").click(function (e) {
                e.preventDefault();
            if($("#activityname").val()==='')
            {
               // alert("Please enter some text!");
                $("#err1").show(); 
                 $('#err1').html("<p>Activity name is required</p>");
                return false;
            }
                            
            //var myData = 'project_name='+ $("#projecttitle").val()+'&project_description='+ $("#description").val(); //build a post data structure
            jQuery.ajax({
            type:"POST", // HTTP method POST or GET
            url: "addActivity.php", //Where to make Ajax calls
            dataType:"json", // Data type, HTML, json etc.
            data:$("#formactivity").serialize(), //Form variables
            success:function(response){
                //alert("success");
                //alert(response.num1);
                if (response.num1===1){
                // alert("status");
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
                $('#err1').html("");    
                //$('#tappit').show(); 
                $('#smallModal').modal('hide');
                }
            },
            error:function (xhr, ajaxOptions, thrownError){
                
               alert(thrownError);
            }
            });
    });


              $(function(){
                   
           
            $("#projecttitle").click(function() {
            $("#err").hide();
            });
            $("#activityname").click(function() {
            $("#err1").hide();
            });
             $("#cancelproject").click(function() {
                 $('#projecttitle').val('');
                $('#description').val('');
                $('#err').html("");    
            });
                  
                  $("#cancelactivity").click(function() {
                  $('#activityname').val('');  
                $('#err1').html("");    
            });
                  $("#logformReset").click(function() {
                       $('#esttime').show();
                        $('#datepick').hide();
                     
            });
                  
                  
                  
                               
        });
            
            
    $(function(){        
    //$('#esttime').hide();
    $('#datepick').hide();
  
    $('input[type="radio"]').click(function() {
       if($(this).attr('value') == 'present') {
            $('#esttime').show();
           $('#datepick').hide();
            
        }

       else {
           
            $('#esttime').hide();
           $('#esttime').val('');
           $('#datepick').show();
       }
   });
      
});
   

        
        
        $(function () {
            $('#datetimepicker9').datetimepicker();
            $('#datetimepicker10').datetimepicker();
            $("#datetimepicker9").on("dp.change",function (e) {
               $('#datetimepicker10').data("DateTimePicker").setMinDate(e.date);
                //$('#datetimepicker9').data("DateTimePicker").hide();
            });
            $("#datetimepicker10").on("dp.change",function (e) {
               $('#datetimepicker9').data("DateTimePicker").setMaxDate(e.date);
                //$('#datetimepicker10').data("DateTimePicker").hide();
                
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

        <script type="text/javascript">
          var hook = true;
          window.onbeforeunload = function() {
            var active = d3.select("#timer-action").text() == "End";
            console.log(active);
            if (hook && active) {
              return "Did you save your stuff?"
            }
          }
          function unhook() {
            hook=false;
          }
        </script>
  

    </body>


</html>

<?php
 pg_close($db);

?>