<html>

<head>
<style>
h1 {font-family: sans-serif; color: white; text-align: center;}
label {font-family: sans-serif; color: white; text-align: center;}
.image {text-align: center;}
.form-control {text-align: center; }
.login-button {text-align: center;}
form  { display: table; margin: 0 auto; width:280px; }
p     { display: table-row;  }
//button { display: table-caption; }
label { display: table-cell; }
input { display: table-cell; }
button {width: 150px; height: 25px;}
</style>
</head>

<body style="background-color:#2F2D91">
<div class="image">
    <img src="zemployed_logo.png" alt="Logo" class="center" width="800"/>
</div>
<title>Zemployed Recruiter Login</title>
<h1>
    Recruiter Login
</h1>

<form class="bsr-form " action="login_handler.php" method='post' id='login-form'>
    <p>
        <label for="email">Email address</label>
		<input name="email" type="email" class="form-control" id="inputemail" placeholder="Email">
    </p>
    <p>
		<label for="password">Password</label>
		<input type="password" name='password' class="form-control" id="inputpassword" placeholder="Password">
	</p>
	<p>
		<label></label>
		<button type='submit' class='form-control' id='submit-button'>Login</button>
	</p>
</form>

</body>
</html>
