<!DOCTYPE html>
<head>
<title>
       	Insert Application
</title>
<style>

    .div-table {margin: 0 auto; width:700px; text-align: center;}

    .image {text-align: center;}

	.styled-table {
         border-collapse: collapse;
         margin: 25px 0;
         font-size: 0.9em;
         font-family: sans-serif;
         min-width: 700px;
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
<body>
<body style="background-color:#2F2D91" >

<a href="http://db.cse.nd.edu/cse30246/zemployed/recruiter_home.php"/>
    <div class="image">
        <img src="zemployed_logo.png" alt="Logo" class="center" width="500" />
    </div>
</a>

<div class="div-table">


<?php
$link = new mysqli('localhost', 'wrobson', 'DatabasesRCool', 'wrobson') or die ('Could not connect');
mysqli_select_db($link, 'wrobson');

$user = $_GET['user_id'];
#$date = $_GET['date'];
$date = date("Y-m-d");
$job_id = $_GET['job_id'];

$id_query = "select id from application order by id desc limit 1"; #need id to be int in order to sort
$id_result = $link->query($id_query) or die ('Query Failed');
while($tuple = $id_result->fetch_array(MYSQLI_ASSOC)){
    foreach($tuple as $col_val){
        $id = $col_val + 1;
    }
}



$query = "insert into application values ('$id', '$user', '$job_id', '$date')";
$old_results = mysqli_query($link, $query) or die ('Query Failed');

$query = "SELECT application.id, user_id, first_name, last_name, school, job_id, title, application.date FROM application, user, job where application.user_id=user.id and application.job_id=job.id and job_id = " . $job_id;
$results = mysqli_query($link, $query) or die ('Query Failed');

echo "<table class=\"styled-table hover-table\">\n";
echo "\t<thead><tr><td>ID</td><td>User</td><td>First Name</td><td>Last Name</td><td>School</td><td>Job ID</td><td>Title</td><td>Date</td></tr></thead>\n";
while($tuple = $results->fetch_array(MYSQLI_ASSOC)){
        echo "\t<tr>";
        foreach($tuple as $col_val){
                echo "<td>$col_val</td>";
        }
	echo "</tr>\n";
}
echo "</table>\n";
?>

</body>
</html>
