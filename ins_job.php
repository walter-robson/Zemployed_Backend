<?php
session_start();
if(!isset($_SESSION['valid']) || $_SESSION['valid'] = false){
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<head>
<title>
       	Insert Job
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
$link = new mysqli('localhost', 'wrobson', 'DatabasesRCool','wrobson') or die ('Could not connect');
mysqli_select_db($link, 'wrobson') or die ('Could not select wrobson');

if(mysqli_connect_error())
        echo "Connection Error.";

$title = $_GET['title'];
#$date = $_GET['date'];
$date = date("Y-m-d");
$rec_id = $_SESSION['id']; // get the id of the currently logged in recruiter
$stmt = mysqli_stmt_init($link) or die ('failed to prepare statement');

$id_query = "SELECT id FROM job ORDER BY id DESC LIMIT 1"; #need id to be int in order to sort
mysqli_stmt_prepare($stmt, $id_query) or die ('failed to prepare statement');
#echo $id_query;
$id_result = $link -> query($id_query) or die ('failed to get result');

#$id_result = mysqli_stmt_get_result($stmt) or die ('Query Failed');
#$id_result = mysqli_query($link, $id_query) or die ('Query Failed');

$tuple = $id_result->fetch_array(MYSQLI_ASSOC) or die ('failed to get tuple');

$id = $tuple['id'] + 1;
#echo $id;
$query = "insert into job values ('$id', '$title', '$date', $rec_id)";
$old_results = $link->query($query) or die ('Query Failed');


$query = "select id, title, date, recruiter_id from job where recruiter_id=$rec_id";
$results = mysqli_query($link, $query) or die ('Query Failed');

echo "<table class=\"styled-table hover-table\">\n";
echo "\t<thead><tr><td>ID</td><td>Title</td><td>Start Date</td><td>Recruiter ID</td></tr></thead>\n";

while ($tuple = $results->fetch_array(MYSQLI_ASSOC)){
        echo "\t<tr>";
        foreach($tuple as $col_val){
                echo "<td>$col_val</td>";
        }
	echo "</tr>\n";
}
echo "</table>\n";
mysqli_close($link);
?>

</body>
</html>
