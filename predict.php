<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>
	Personality Type
</title>
<style>

    h3 {font-family: sans-serif; color: white; text-align: center;}

    .div-table {margin: 0 auto; width:800px; text-align: center;}

    .image {text-align: center;}

	.styled-table {
         border-collapse: collapse;
         margin: 25px 0;
         font-size: 0.9em;
         font-family: sans-serif;
         min-width: 800px;
         box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
      }
      .styled-table thead tr {
         background-color: #87878A;
         color: #ffffff;
         text-align: left;
      }

      .styled-table th,
      .styled-table td {
         padding: 12px 15px;
      }

      .styled-table tbody tr {
         border-bottom: 1px solid #dddddd;
      }

      .styled-table tbody tr:nth-of-type(even) {
         background-color: #f3f3f3;
      }

      .styled-table tbody tr:nth-of-type(odd) {
         background-color: #dddddd;
      }

      .styled-table tbody tr:hover {
         background-color:#e0e0e0;
      }

      .styled-table tbody tr.active-row {
         font-weight: bold;
		 color: #009879;
		 border: 1px solid black;
      }
</style>
</head>


<body style="background-color:#2F2D91">

 <a href="http://db.cse.nd.edu/cse30246/zemployed/recruiter_home.php"/>
     <div class="image">
        <img src="zemployed_logo.png" alt="Logo" class="center" width="500" />
     </div>
</a>
<?php
	$job_id = $_GET['job_id'];
	$archetype = $_GET['archetype-select'];
	$command = escapeshellcmd("/var/www/html/cse30246/zemployed/venv/bin/python3 predict.py " . $archetype . " " . $job_id);
	$command = $command . " Performers 1";
	$output = shell_exec($command);
	echo $output;
?>

