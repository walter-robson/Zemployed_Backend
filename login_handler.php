<?php
session_start();
echo "in login handler";
?>
<!DOCTYPE html>
<html>
<head></head>
<body>
<?php
$inputemail = $_POST["email"];
$inputpassword = $_POST["password"];

$link = mysqli_connect('localhost', 'wrobson', 'DatabasesRCool') or die ('dead');
mysqli_select_db($link, 'wrobson');

if($stmt = mysqli_prepare($link, "SELECT id, first_name, last_name FROM recruiter WHERE password=PASSWORD(?) and email=?;")){
	
	// bind parameters
	$stmt->bind_param('ss', $inputpassword, $inputemail);

	// execute
	$stmt->execute();
	$stmt->store_result();
	$num_rows = $stmt->num_rows();
	//echo "<p>".$num_rows."</p>\n";
	//mysqli_stmt_bind_result
	// bind variables to prepared statement
	mysqli_stmt_bind_result($stmt, $col1, $col2, $col3);

	// fetch values
	//if(mysqli_stmt_fetch($stmt)) {
	//	printf("<p>%s %s %s</p>\n", $col1, $col2, $col3);
	//}

	// work with results - i.e. determine whether or not to log in
	//$num_rows = mysqli_stmt_num_rows($result);
	//echo 'num rows: '.$num_rows.';\n';
	if($num_rows > 0) {
		if(mysqli_stmt_fetch($stmt)){
			$_SESSION['id']=$col1;
			$_SESSION['first_name']=$col2;
			$_SESSION['last_name']=$col3;
			$_SESSION['valid'] = true;
		}

		header('Location: recruiter_home.php');
		echo 'Welcome, '.tuple["first_name"];
		exit();
	}
	else{
		echo "username and password not recognized";
	}

	// close statement
	mysqli_stmt_close($stmt);
}

// close link
mysqli_close($link);

?>
</body>
</html>
