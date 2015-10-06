<?php require_once('includes/connection.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php confirm_logged_in(); //confirm whether the user logged in ?>
<?php 
       if(isset($_POST['update_username_btn'])){
		   $username =  mysql_prep($_POST['username']);
		   
		   $form_data = array('username' => $username);
		   dbRowUpdate('users' , $form_data  , " WHERE id = 1");
		   redirect_to("settings.php");
		   }
		   elseif(isset($_POST['update_password_btn'])){
			    
				   $password =  mysql_prep($_POST['pwd']);
				   $password = MD5($password);
		   
				   $form_data = array('password' => $password);
				   dbRowUpdate('users' , $form_data  , " WHERE id = 1");
				   redirect_to("settings.php");
			   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>ToDo</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/sticky-footer.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<body style="background-color: #03437B;">

<div class="container" style="background-color:#fff;">
  <h1 align="center" style="border-bottom: 4px double #fff; background-color: #655E46; color: #fff;">ToDo</h1>

  <ul class="nav nav-tabs" role="tablist">
    <li><a href="index.php">ToDo</a></li>
    <li  class="active"><a href="settings.php">Settings</a></li>
    <li><a href="logout.php">Logout</a></li>       
  </ul> 
  
  
<hr style="border: 4px double #ccc;" />

            <div class="col-md-6">
             <h2>Update Username</h2>
             
              
             <hr>
              <form role="form" action="settings.php" method="post" >
              <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" value="<?php 
				$result = dbRowSelect('users', " WHERE id = 1 ");
			    while($row = mysql_fetch_array($result)) { echo  $row['username']; }
				 ?>" name="username" required>
              </div>
            
             <button type="submit" name="update_username_btn" class="btn btn-primary">Submit</button>
            </form>
            
            </div>
            
            <div class="col-md-6">
             <h2>Change Password</h2>
             <hr>
             <script>
			  function chkpassword(){
				  var PWD = document.changepasswordForm.pwd.value;
				  var PWD2 = document.changepasswordForm.pwd2.value;
				  
				  if(PWD != PWD2){
					  alert('Passwords Do not Match');
					  return false;
					  }
					  
					if( (PWD == "") || (PWD == "")){
						
						alert('Please Enter your new password and confirm password');
						return false;
						}
				   
				   alert('Password Has been updated successfully');
				   return true;
				  }
			 
			 </script>
              <form role="form" action="settings.php" name="changepasswordForm" onSubmit="return chkpassword();" method="post"  >
               <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" name="pwd" >
              </div>
              
              <div class="form-group">
                <label for="pwd">Confirm Password:</label>
                <input type="password" class="form-control" name="pwd2"  >
              </div>
            
            
              <button type="submit" name="update_password_btn" class="btn btn-primary">Submit</button>
            </form>
            <br>
            </div>



<hr style="border: 4px double #ccc; clear:both;    margin: 40px 0px;" /> 

</div>
  
 
  
<footer class="footer">
      <div class="container">
        <p class="text-muted" style="margin-top: 15px;font-size: 20px;color: #03437B;">ToDo Application</p>
      </div>
 </footer> 
 
 
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>

</body>
</html>