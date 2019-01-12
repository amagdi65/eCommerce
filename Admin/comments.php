<?php
session_start();
	  if(isset($_SESSION['Username']))
	  {
	  	$title="Comments";
	  	include "ini.php";
	  	$do=isset($_GET['do'])? $_GET['do']:"Manage";
	  	if($do=="Manage")
	  	{
			$stmt=$con->prepare("SELECT comments.*, items.Name AS item_name ,users.username FROM comments 
                 INNER JOIN items ON items.item_ID=comments.item_id
                INNER JOIN users ON users.userId=comments.user_id");
	  		$stmt->execute();
	  		$row=$stmt->fetchAll();

	  	?>

	  		<h1 class="text-center">Manage comments</h1>
	  		<div class="container">
	  			<table class="table table-bordered">
				  <thead class="thead-dark">
				    <tr>
				      <th scope="col" class="text-center">#ID</th>
				      <th scope="col" class="text-center">Comment</th>
				      <th scope="col" class="text-center">Item Name</th>
				      <th scope="col" class="text-center">UserName</th>
				      <th scope="col" class="text-center">Added Date</th>
				      <th scope="col" class="text-center">Control</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php
				  		foreach ($row as $value) {
				  			echo "<tr>";
				      		echo "<th class='text-center' scope='row'>".$value['c_id']."</th>";
				      		echo "<td class='text-center'>".$value['comment']."</td>";
				      		echo "<td class='text-center'>".$value['item_name']."</td>";
				      		echo "<td class='text-center'>".$value['username']."</td>";
				      		echo "<td class='text-center'>".$value['comment_date']."</td>";
							echo "<td class='text-center'>
				      		<a href='comments.php?do=Edit&commentid=".$value['c_id']."'class='btn btn-success'><i class='far fa-edit'></i> Edit</a>
									<a href='comments.php?do=Delete&commentid=".$value['c_id']."' class='btn btn-danger confirm'><i class='far fa-trash-alt'></i> Delete</a>";
									if($value['status']==0)
									{
									echo "<a href='comments.php?do=Approve&commentid=".$value['c_id']."' class='btn btn-info '><i class='fas fa-check-circle'></i> Approve</a>";
									}
									
				      		echo"</td>";
				      		echo "</tr>";
				    			      	
				    
				      
				  		}
				  	?>
				 
				  </tbody>
				</table>

	  		</div>
	  	<?php
	  	}
	  	elseif ($do =="Edit") {
	  		$comid=isset($_GET['commentid'])&&is_numeric($_GET['commentid'])? intval($_GET['commentid']) : 0;
	  		$stmt= $con->prepare("SELECT * FROM comments Where c_id=?");
	  		$stmt->execute(array($comid));
	  		$row= $stmt->fetch();
	  		$count=$stmt->rowCount();
	  		if($count>0)
	  		{


	  		?>
	  		<h1 class="text-center">Edit Comment</h1>
	  		<div class="container">
	  			<form method="POST" action="?do=Update">
					  <div class="form-group row">
					    <label for="staticEmail" class="col-sm-2 col-md-offset-6 col-form-label">Comment</label>
					    <div class="col-sm-10 col-md-6">
                            <textarea class="form-control" name="comment"  required><?php echo $row['comment']?></textarea>
					      <input type="text" hidden name="commentid" value="<?php echo $comid?>" >
					    </div>
					  </div>
					  <div class="form-group row">
					  	<div class="col-sm-2 offset-md-2"></div>
					    <div class="col-sm-8">
					      <input type="submit" class="btn btn-primary btn-lg"  value="Save">
					    </div>
					  </div>
				</form>
	  		</div>
	  	<?php
	  		}
	  		else
	  		{
	  			echo "<div class='alert alert-danger'>there is no such id</div>";
	  		} 
	  	}
	  	else if($do=="Update")
	  	{
	  		
	  		if(isset($_POST['comment']))
	  		{
	  			echo "<h1 class='text-center'>Update Comment</h1>";
	  			echo "<div class='container'>";
                $comm=$_POST['comment'];
                $cid=$_POST['commentid'];
                  
	  			$error_arr= array();
	  			if(!empty($comm))
	  			{
	  				
	  			
	  					$stmt=$con->prepare("UPDATE comments SET comment=?  WHERE c_id=?");
	  					$stmt->execute(array($comm,$cid));
	  					echo "<div class='alert alert-success'>".$stmt->rowCount()."Record Updated</div>";
	  					redirect(2,"back","comments.php");

	  				
	  				
                  }
                  else
                  {
                    echo "<div class='alert alert-danger'>the comment can't be empty</div>";
                  }
	  		}
	  		else
	  		{
	  			echo "<div class='alert alert-danger'>you can't browse this page directly</div>"."<br>";
	  					
	  			redirect(2,"back");
	  		}
	  		
	  		echo "</div>";
	  	}
	  	elseif($do=="Delete")
	  	{
	  		echo "<div class='container'>";
	  		echo "<h1 class='text-center'>Delete Member</h1>";
	  		$comm=isset($_GET['commentid'])&&is_numeric($_GET['commentid'])? intval($_GET['commentid']) : 0;
	  		if(checkitem("c_id","comments",$comm)==1)
	  		{
	  			$stmt=$con->prepare("DELETE FROM comments WHERE c_id=?");
	  			$stmt->execute(array($comm));
	  			echo "<div class='alert alert-success'>".$stmt->rowCount()."Record Deleted</div>";
	  			redirect(2,"members.php","comments.php");	
	  		}else
	  		{
	  			echo "<div class='alert alert-danger'>there is no such id</div>";
	  			redirect(2,"members.php","members.php");
	  		}
	  		
	  		echo "</div>";

			}
			elseif($do=="Approve")
			{
				echo "<div class='container'>";
	  		echo "<h1 class='text-center'>Activate Member</h1>";
	  		$comm=isset($_GET['commentid'])&&is_numeric($_GET['commentid'])? intval($_GET['commentid']) : 0;
	  		if(checkitem("c_id","comments",$comm)==1)
	  		{
	  			$stmt=$con->prepare("UPDATE  comments SET status=1 WHERE c_id=?");
	  			$stmt->execute(array($comm));
	  			echo "<div class='alert alert-success'>".$stmt->rowCount()."Record Updated</div>";
	  			redirect(2,"members.php","comments.php");	
	  		}else
	  		{
	  			echo "<div class='alert alert-danger'>there is no such id</div>";
	  			redirect(2,"members.php","members.php");
	  		}
	  		
	  		echo "</div>";


			}
	  	include "includes/templates/footer.php";
	  }
	  else
	  {
	  	header("location : index.php");
	  	exit();
	  }

