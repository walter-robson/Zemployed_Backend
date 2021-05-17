<?php
session_start();
if(!isset($_SESSION['valid']) || $_SESSION['valid'] = false){
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<style>
.body {text-align: center;}
h1 {font-family: sans-serif; color: white; text-align: center;}
h2 {font-family: sans-serif; color: #bbbbbf; text-align: center;}
h3 {font-family: sans-serif; color: #DDDDDD; text-align: center;}
label {font-family: sans-serif;}
.image {text-align: center;}

.form  { display: table; margin: 0 auto; width:400px; }
.form-group     { display: table-row;  }
label { display: table-cell; width: 180px; }
input { display: table-cell; width: 180px; }

.form-control-dropdown {width: 190px;}
.buttons {text-align: center;}

</style>
</head>

<div class="body">
<body style="background-color:#2F2D91">
<a href="http://db.cse.nd.edu/cse30246/zemployed/recruiter_home.php"/>
	<div class="image">
		<img src="zemployed_logo.png" alt="Logo" width="800"/>
	</div>
</a>

  <h1 style="color:white";"font-family:sans-serif";"font-style:sans-serif">Recruiter Home</h1>

	<p style="color:white";"font-family:sans-serif";"font-style:sans-serif">
		Welcome, <?php echo $_SESSION['first_name']; ?>
	</p>
  
    <h2>Insert Job</h2>
      
      <form class='bsr-form ' action='ins_job.php'>
        <div class="form">
        <div class='form-group'>
          <label style="color:white" for='title'>Job Title</label>
          <input name='title' type='text' class='form-control' id='job-title'></div>
        <!--<div class='form-group'>
          <label style="color:white" for='recruiter'>Recruiter</label>
          <input name='recruiter' type='text' class='form-control' id='job-recruiter'>
        </div>-->
        </div>
        <div class="buttons">
            <button type='reset' class='btn btn-default' id='job-clear-button'>Clear</button>
            <button type='submit' class='btn btn-primary' id='job-submit-button'>Submit</button>
        </div>
        </form>

    <h2>Update Job</h2>

      <form class="bsr-form" action="update_job.php">
        <div class="form">
         <div class="form-group">
           <label style="color:white" for="job_id">Job ID</label>
           <input name="job_id" type="text" class="form-control" id="update-job-id">
         </div>
         <div class="form-group">
           <label style="color:white" for="checkboxes">Select value to update:</label>
           <select class='form-control-dropdown' name='title-recruiter' id="update-job-select">
              <option value="title">job title</option>
              <option value="recruiter">recruiter</option>
           </select>
         </div>
         <div class="form-group">
           <label style="color:white" for="new_value">New value:</label>
           <input name="new_value" type="text" class="form-control" id="update-job-field">
         </div>
         </div>
        <div class="buttons">
           <button type="reset" class="btn btn-default" id="update-job-clear-button">Clear</button>
           <button type="submit" class="btn btn-primary" id="update-job-submit-button">Submit</button>
        </div>
        </form>

    <h2>Delete Job</h2>

      <form class='bsr-form ' action='del_job.php'>
        <div class="form">
        <div class='form-group'>
          <label style="color:white" for='job_id'>Job ID</label>
          <input name='job_id' type='text' class='form-control' id='delete-job-id'>
        </div>
        </div>
        <div class="buttons">
            <button type='reset' class='btn btn-default' id='delete-job-clear-button'>Clear</button>
            <button type='submit' class='btn btn-primary' id='delete-job-submit'>Submit</button>
        </div>
        </form>

    <h2>Show All Jobs</h2>

       <form class='bsr-form ' action='show_all_jobs.php'>
         <button type='jobs' class='btn btn-primary' id='show-jobs-button'>Jobs</button>
       </form>

    <h2>Show My Jobs</h2>

      <form class='bsr-form ' action='show_jobs.php'>
        <button type='jobs' class='btn btn-primary' id='show-jobs-button'>Jobs</button>
      </form>

    <h2>Insert Application</h2>

      <form class='bsr-form ' action='ins_app.php'>
        <div class="form">
        <div class='form-group'>
          <label style="color:white" for='user_id'>User ID</label>
          <input name='user_id' type='text' class='form-control' id='insert-app-user-id'></div>
        <div class='form-group'>
          <label style="color:white" for='job_id'>Job ID</label>
          <input name='job_id' type='text' class='form-control' id='insert-app-job-id'>
        </div>
        </div>
        <div class="buttons">
            <button type='reset' class='btn btn-default' id='insert-app-clear-button'>Clear</button>
            <button type='submit' class='btn btn-primary' id='insert-app-submit-button'>Submit</button>
        </div>
        </form>

    <h2>Update Application</h2>

      <form class="bsr-form " action="update_app.php">
           <div class="form">
           <div class="form-group">
		       <label style="color:white" for="application_id">Application ID</label>
		       <input name="application_id" type="text" class="form-control" id="update-app-app-id">
	       </div>
	       <div class="form-group">
		       <label style="color:white" for="checkboxes">Select value to update:</label>
		       <select class="form-control-dropdown" name='app-dropdown' id="app-dropdown">
			        <option value="user_id">User ID</option>
					<option value="job_id">Job ID</option>
					<option value="date">Date</option>
	         </select>
	       </div>
	       <div class="form-group">
		       <label style="color:white" for="new_value">New value:</label>
		       <input name="new_value" type="text" class="form-control" id="update-app-input">
          </div>
          </div>
          <div class="buttons">
	         <button type="reset" class="btn btn-default" id="update-app-clear-button">Clear</button>
	         <button type="submit" class="btn btn-primary" id="update-app-submit-button">Submit</button>
          </div>
          </form>

    <h2>Delete Application</h2>

      <form class='bsr-form ' action='del_app.php'>
        <div class="form">
        <div class='form-group'>
          <label style="color:white" for='application_id'>Application ID</label>
          <input name='application_id' type='text' class='form-control' id='delete-app-app-id'>
        </div>
        </div>
        <div class="buttons">
            <button type='reset' class='btn btn-default' id='delete-app-clear-button'>Clear</button>
            <button type='submit' class='btn btn-primary' id='delete-app-submit-button'>Submit</button>
        </div>
        </form>
       
    <h2>Show Applications</h2>

      <form class='bsr-form ' action='show_apps.php'>
        <div class="form">
        <div class='form-group'>
          <label style="color:white" for='job_id'>job_id</label>
          <input name='job_id' type='text' class='form-control' id='show-apps-job-id'>
        </div>
        </div>
        <div class="buttons">
            <button type='reset' class='btn btn-default' id='show-apps-clear-button'>Clear</button>
            <button type='submit' class='btn btn-primary' id='show-apps-submit-button'>Submit</button>
        </div>
        </form>


    <h2>Group Applicants</h2>

      <form class='bsr-form ' action='kmeans_v2.php'>
        <div class="form">
        <div class='form-group'>
          <label style="color:white" for='job_id'>Job ID</label>
          <input name='job_id' type='text' class='form-control' id='group-apps-job-id'>
        </div>
        </div>
        <div class="buttons">
            <button type='reset' class='btn btn-default' id='group-apps-clear-button'>Clear</button>
            <button type='submit' class='btn btn-primary' id='group-apps-submit-button'>Submit</button>
          </div>
        </form>

    <h2>Sort Applicants</h2>

    <form class="bsr-form " action="sort.php">
    <div class="form">
        <div class="form-group">
            <label style="color:white" for="text-input">Job ID</label>
            <input name="sort_apps_job_id" type="text" class="form-control" id="input-text-6991422">
        </div>
    </div>
    <h3>GPA Information:</h3>
    <div class="form">
        <div class="form-group">
            <label style="color:white" for="text-input">GPA</label>
            <input name="GPA" type="text" class="form-control" id="input-text-9946179">
        </div>
        <div class='form-group'>
             <label style="color:white" for="exampleInputAmount">Weight</label>
             <input name="GPA_weight" type="text" class="form-control" id="exampleInputAmount">
        </div>
    </div>
    <h3>Personality Test Information:</h3>
    <div class="form">
        <div class='form-group'>
            <label style="color:white" for="exampleInputAmount">Extroversion</label>
            <input name="p_e" type="text" class="form-control" id="exampleInputAmount">
        </div>
        <div class='form-group'>
            <label style="color:white" for="exampleInputAmount">Agreeableness</label>
            <input name="p_a" type="text" class="form-control" id="exampleInputAmount">
        </div>
        <div class='form-group'>
            <label style="color:white" for="exampleInputAmount">Openness</label>
            <input name="p_o" type="text" class="form-control" id="exampleInputAmount">
        </div>
        <div class='form-group'>
            <label style="color:white" for="exampleInputAmount">Conscientiousness</label>
            <input name="p_c" type="text" class="form-control" id="exampleInputAmount">
        </div>
        <div class='form-group'>
            <label style="color:white" for="exampleInputAmount">Neuroticism</label>
            <input name="p_n" type="text" class="form-control" id="exampleInputAmount">
        </div>
        <div class='form-group'>
            <label style="color:white" for="exampleInputAmount">Weight</label>
            <input name="personality_weight" type="text" class="form-control" id="exampleInputAmount">
        </div>
    </div>
        <button type='reset' class='btn btn-default' id='show-apps-clear-button'>Clear</button>
        <button type='submit' class='btn btn-primary' id='show-apps-submit-button'>Submit</button>
    </form>

    <h2>Find Archetypes</h2>

      <form class="bsr-form" action="predict.php">
        <div class="form">
         <div class="form-group">
           <label style="color:white" for="job_id">Job ID</label>
           <input name="job_id" type="text" class="form-control" id="update-job-id">
         </div>
         <div class="form-group">
           <label style="color:white" for="checkboxes">Desired Archetype:</label>
           <select class='form-control-dropdown' name='archetype-select' id="update-job-select">
              <option value="Performers">Performance</option>
              <option value="Creatives">Creativity</option>
              <option value="Managers">Management</option>
           </select>
         </div>
         </div>
        <div class="buttons">
           <button type="reset" class="btn btn-default" id="update-job-clear-button">Clear</button>
           <button type="submit" class="btn btn-primary" id="update-job-submit-button">Submit</button>
        </div>
	</form>
<!--
	<h2>Test PHP to Python Connection</h2>
    <form class='bsr-form ' action='test_python.php'>
        <button type='submit' class='btn btn-primary' id='test-python-button'>Test Python</button>
	</form>
-->
</body>

</div>

</html>
