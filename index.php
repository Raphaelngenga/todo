<?php require_once('includes/connection.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php confirm_logged_in(); //confirm whether the user logged in ?>
<?php 
      
	  
	   //ADD
	   if(isset($_POST['add_todo_btn'])){//
		  $todo = mysql_prep($_POST['todo']);
		  
		  $form_data = array( 'todo_item' => $todo);
		  
		  dbRowInsert('todo_list', $form_data);
		  
		  redirect_to("index.php?submitted=true");
		 }//
		 
		   // DONE OR NOT DONE ACTION
		   elseif(isset($_GET['done'])){
			 $action = mysql_prep($_GET['done']);
			 $id = mysql_prep($_GET['id']);
			 
						 if($action == 1){ //done
						   $form_data = array('todo_status' => 'Done');
						 }
						 else{ //not done
						   $form_data = array('todo_status' => 'Not Done'); 
							 }
							 
						dbRowUpdate('todo_list', $form_data , " WHERE id = $id ");
						
						redirect_to("index.php");
			 
			 }
			 
			  //DELETE
	     	  elseif(isset($_GET['deleteid'])){
			  $id = mysql_prep($_GET['deleteid']);
			  
			  dbRowDelete('todo_list',  " WHERE id = $id ");
			  
			  redirect_to("index.php");
			   }
			   //UPDATE / EDIT
			   elseif(isset($_POST['edit_btn'])){
				   $id = mysql_prep($_POST['id']); 
				   $todo = mysql_prep($_POST['todo_edit']); 
				   
				   $form_data = array( 'todo_item' => $todo);
				  
				   dbRowUpdate('todo_list', $form_data , " WHERE id = $id ");
				   redirect_to("index.php");
				   
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
    <li class="active"><a href="index.php">ToDo</a></li>
    <li><a href="settings.php">Settings</a></li>
    <li><a href="logout.php">Logout</a></li>       
  </ul> 
  
  
<hr style="border: 4px double #ccc;" />
 
  <?php  if(isset($_GET['submitted'])) { //added todo item successfully ?>
  
  <div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> Added A todo item.
  </div>
  <?php } ?>
<div class="col-md-6">
 <h2>Todos</h2>
                <form action="index.php" method="post" >
                <input type="text" class="form-control add-todo" placeholder="Add todo" name="todo" required><br>
                <button type="submit" class="btn btn-primary" name="add_todo_btn">Submit</button>
                </form>
                    
                    <hr>
                    <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>ToDo</th>
                        <th style="text-align:center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    
                    <?php 
					$result = dbRowSelect('todo_list' , " WHERE todo_status = 'Not Done' ");
					$count = 1; 
			        while ($row = mysql_fetch_array($result)) {
					
					 ?>
                      <form action="index.php" method="post">
                      <input type="hidden" name="id" value="<?php echo $row['id']; ?>"  />
                      <tr>
                        <td><?php echo $count; ?></td>
                        <td><input type="text" value= "<?php echo $row['todo_item']; ?>" name="todo_edit" /> </td>
                        <td style="text-align:center" > 
                       <a href="index.php?done=1&amp;id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Done" class="btn btn-success btn-xs"> <span class="glyphicon glyphicon-thumbs-up"></span> </a>
                       
                       <button type="submit" data-toggle="tooltip" data-placement="top" title="Edit" name="edit_btn" class="btn btn-info btn-xs"> <span class="glyphicon glyphicon-edit"></span> </button>
                       
                       <a href="index.php?deleteid=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Delete this?')"> <span class="glyphicon glyphicon-trash"></span> </a></td>
                      </tr>
                      </form> 
                      <?php  
					  $count++; 
					  } ?>
                    </tbody>
                  </table>
             
</div>

<div class="col-md-6">
 <h2>Done</h2>
 <hr>
                    <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>ToDo</th>
                        <th style="text-align:center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php 
					$result = dbRowSelect('todo_list' , " WHERE todo_status != 'Not Done' ");
					$count = 1; 
			        while ($row = mysql_fetch_array($result)) {
					
					 ?>
                      <form>
                      <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row['todo_item']; ?></td>
                        <td style="text-align:center" > 
                       <a href="index.php?done=0&amp;id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Not Done" class="btn btn-warning btn-xs"> <span class="glyphicon glyphicon-thumbs-down"></span> </a>
                        
                       <a href="index.php?deleteid=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Delete this?')"> <span class="glyphicon glyphicon-trash"></span> </a></td>
                      </tr>
                      </form> 
                       <?php  
					  $count++; 
					  } ?>
                      
                    </tbody>
                  </table>
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