<html>
	<head>
		<title>Tapp It</title>
		<link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    	<link rel="stylesheet" type="text/css" href="http://dc-js.github.io/dc.js/css/dc.css"/>
    	<link href="/css/sticky-footer.css" rel="stylesheet">
    	<style>
        #work-history-chart g.y {
            display: none;
        }
    	</style>
	</head>
	<body>
		<div class="container">

			<div class="page-header">
				<h1>TappIt <span class="glyphicon glyphicon-book" aria-hidden="true"></span></h1>
				<a href="/dialogHome.php">
					<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
					Home
				</a>
				<a href="/report.php">
					<span class="glyphicon glyphicon glyphicon-signal" aria-hidden="true"></span>
					View report
				</a>
				<a href="/logout.php">
					<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
					Logout
				</a>
			</div>

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
				   /*if(!$db){
				      echo "Error : Unable to open database\n";
				   } else {
				      echo "Opened database successfully\n";
				   }
*/
				$ret = pg_query($db, "select * from performance_details2 where username='".$user."';");

				// Get Records from the table
				$data_array = array();
				while ($row = pg_fetch_array($ret,NULL,PGSQL_ASSOC)) {
					array_push($data_array, $row);
				}
				//print_r($data_array);
				/*
				$result_rows = array();
				$result_rows = pg_copy_to ( $db, "temptable","," );

					if ( ! $result_rows ) { echo "No result!<BR>"; return; }

					foreach( $result_rows as $row ) {
						echo $row;
					}
				echo $res;
				*/
			?>
			<script type="text/javascript">
			    user_data = <?php echo json_encode($data_array); ?>;
			    //Export to CSV file
			</script>
			<p>
				<h2>TappIt</h2> 
				<a id="download_report" href="#">
					<span class="glyphicon glyphicon-download" aria-hidden="true"></span>
					Download report
				</a>
			</p>
			<div id="work-history-chart"></div>
			<div id="project-history-chart" style="position:relative">
				<div id="project-estimated-chart" style="position:absolute"></div>
			</div>
			<div>
				<div id="project-dedication-chart"></div>
				<div id="activity-dedication-chart"></div>
			</div>

			<div class="row">
				<table class="table table-hover dc-data-table">
			        <thead>
			        <tr class="header">
			            <th>Date</th>
			            <th>Project name</th>
			            <th>Acivity</th>
			            <th>Estimated time</th>
			            <th>Dedicated time</th>
			        </tr>
			        </thead>
			    </table>
			</div>
		</div>

		<div class="footer">
			<p class="muted credit"><p>©TappIt. Improving your performance 2014</p></p>
		</div>

		<script type="text/javascript" src="http://dc-js.github.io/dc.js/js/d3.js"></script>
		<script type="text/javascript" src="http://dc-js.github.io/dc.js/js/crossfilter.js"></script>
		<script type="text/javascript" src="http://dc-js.github.io/dc.js/js/dc.js"></script>
		<script type="text/javascript" src="http://dc-js.github.io/dc.js/js/colorbrewer.js"></script>
		<script type="text/javascript" src="/bower_components/jquery/dist/jquery.min.js"></script>
		<script type="text/javascript" src="report.js"></script>

	</body>

</html>
