<!DOCTYPE html>
<head>
<title>
       	Applications Database
</title>
<style>

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

<div class="div-table">

<?php
$link = mysqli_connect('localhost', 'wrobson', 'DatabasesRCool') or die ('Could not connect');
mysqli_select_db($link, 'wrobson');

$job = $_GET['job_id'];

$query = "SELECT application.id, user_id, first_name, last_name, school, job_id, title, application.date FROM application, user, job where application.user_id=user.id and application.job_id=job.id and job_id = " . $job;
$results = mysqli_query($link, $query) or die ('Query Failed');

echo "<table class=\"styled-table hover-table\">\n";
echo "\t<thead><tr><td>ID</td><td>User</td><td>First Name</td><td>Last Name</td><td>School</td><td>Job ID</td><td>Title</td><td>Date</td></tr></thead>\n";
//while($tuple = mysqli_fetch_array($results, MYSQL_ASSOC)){
while ($tuple = $results->fetch_array(MYSQLI_ASSOC)){
        echo "\t<tr>";
        foreach($tuple as $col_val){
                echo "<td>$col_val</td>";
        }
	echo "</tr>\n";
}
echo "</table>\n";
?>

</div>
</body>
</html>
