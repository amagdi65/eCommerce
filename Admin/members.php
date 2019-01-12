<?php
session_start();
	  if(isset($_SESSION['Username']))
	  {
	  	$title="Members";
	  	include "ini.php";
	  	$do=isset($_GET['do'])? $_GET['do']:"Manage";
	  	if($do=="Manage")
	  	{
				$query="";
				if(isset($_GET['page'])&&$_GET['page']=="pending")
				{
					$query="AND RegStatus = 0";
				}
				$stmt=$con->prepare("SELECT * FROM users WHERE 	GroupID != 1 $query");
	  		$stmt->execute();
	  		$row=$stmt->fetchAll();


	  	?>

	  		<h1 class="text-center">Manage Members</h1>
	  		<div class="container">
	  			<table class="table table-bordered manage-member">
				  <thead class="thead-dark">
				    <tr>
							<th scope="col" class="text-center">#ID</th>
							<th scope="col" class="text-center">UserName</th>
							<th scope="col" class="text-center">Avatar</th>
				      <th scope="col" class="text-center">Email</th>
				      <th scope="col" class="text-center">FullName</th>
				      <th scope="col" class="text-center">Registred Date</th>
				      <th scope="col" class="text-center">Control</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php
				  		foreach ($row as $value) {
				  			echo "<tr>";
				      		echo "<th class='text-center' scope='row'>".$value['userId']."</th>";
									echo "<td class='text-center'>".$value['username']."</td>";
									echo "<td class='text-center'>";
									if(empty($value['avatar']))
									{
										echo "there is no image";
									}else
									{
										echo "<img src='uploads/avatar/".$value['avatar']."'/>";
									}
									echo "</td>";
				      		echo "<td class='text-center'>".$value['Email']."</td>";
				      		echo "<td class='text-center'>".$value['fullname']."</td>";
				      		echo "<td class='text-center'>".$value['Date']."</td>";
							echo "<td class='text-center control'>
				      		<a href='members.php?do=Edit&userid=".$value['userId']."'class='btn btn-success'><i class='far fa-edit'></i> Edit</a>
									<a href='members.php?do=Delete&userid=".$value['userId']."' class='btn btn-danger confirm'><i class='far fa-trash-alt'></i> Delete</a>";
									if($value['RegStatus']==0)
									{
									echo "<a href='members.php?do=Activate&userid=".$value['userId']."' class='btn btn-info '><i class='fas fa-check-circle'></i> Activate</a>";
									}
									
				      		echo"</td>";
				      		echo "</tr>";
				    			      	
				    
				      
				  		}
				  	?>
				 
				  </tbody>
				</table>

	  		
	  			<a href='members.php?do=Add' class="btn btn-primary add"><i class="fas fa-plus"></i> New Member</a>
	  		</div>
	  	<?php
	  	}
	  	elseif ($do =="Edit") {
	  		$userid=isset($_GET['userid'])&&is_numeric($_GET['userid'])? intval($_GET['userid']) : 0;
	  		$stmt= $con->prepare("SELECT * FROM users Where userId=?");
	  		$stmt->execute(array($userid));
	  		$row= $stmt->fetch();
	  		$count=$stmt->rowCount();
	  		if($count>0)
	  		{


	  		?>
	  		<h1 class="text-center">Edit Member</h1>
	  		<div class="container">
	  			<form method="POST" action="?do=Update">
					  <div class="form-group row">
					    <label for="staticEmail" class="col-sm-2 col-md-offset-6 col-form-label">Username</label>
					    <div class="col-sm-10 col-md-6">
					      <input type="text"  class="form-control" id="staticEmail" placeholder="enter username" autocomplete="off" name="username" value="<?php echo $row['username'] ?>" required="required">
					      <input type="text" hidden name="userid" value="<?php echo $userid?>" >
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="inputPassword" class="col-sm-2 col-md-offset-6 col-form-label">Password</label>
					    <div class="col-sm-10 col-md-6">
					      <input type="password" class="password form-control" id="inputPassword" placeholder="Password" autocomplete="new-password" name="newpassword">
					       <input type="hidden" class="form-control" name="oldpassword" value="<?php echo $row['password']?>" >
					        <i class="eye far fa-eye"></i>
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="inputPassword" class="col-sm-2 col-md-offset-6 col-form-label">Email</label>
					    <div class="col-sm-10 col-md-6">
					      <input type="email" class="form-control" placeholder="email" name="email" autocomplete="off" value="<?php echo $row['Email']?>" required="required">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="inputPassword" class="col-sm-2 col-md-offset-6 col-form-label">Full name</label>
					    <div class="col-sm-10 col-md-6">
					      <input type="text" class="form-control" placeholder="full name" autocomplete="off" name="full" value="<?php echo $row['fullname']?>" required="required">
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
	  	  	elseif ($do =="Add") {
	  	  		//add member
	  		?>
	  		<h1 class="text-center">Add Member</h1>
	  		<div class="container">
	  			<form method="POST" action="members.php?do=Insert" enctype="multipart/form-data">
					  <div class="form-group row">
					    <label for="staticEmail" class="col-sm-2 col-md-offset-6 col-form-label">Username</label>
					    <div class="col-sm-10 col-md-6">
					      <input type="text"  class="form-control" id="staticEmail" placeholder="enter username" autocomplete="off" name="username" required="required">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="inputPassword" class="col-sm-2 col-md-offset-6 col-form-label">Password</label>
					    <div class="col-sm-10 col-md-6">
					      <input type="password" class="password form-control" id="inputPassword" placeholder="Password" autocomplete="new-password" name="password" required="required"> 
					      <i class="eye far fa-eye"></i>
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="inputPassword" class="col-sm-2 col-md-offset-6 col-form-label">Email</label>
					    <div class="col-sm-10 col-md-6">
					      <input type="email" class="form-control" placeholder="email" name="email" autocomplete="off" required="required">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="inputPassword" class="col-sm-2 col-md-offset-6 col-form-label">Full name</label>
					    <div class="col-sm-10 col-md-6">
					      <input type="text" class="form-control" placeholder="full name" autocomplete="off" name="full" required="required">
					    </div>
						</div>
						<div class="form-group row">
					    <label for="inputPassword" class="col-sm-2 col-md-offset-6 col-form-label">User Avatar</label>
					    <div class="col-sm-10 col-md-6">
					      <input type="file" class="form-control"  autocomplete="off" name="avatar" required="required">
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
	  	else if($do=="Update")
	  	{
	  		
	  		if(isset($_POST['username'])&&isset($_POST['full'])&&isset($_POST['email']))
	  		{
	  			echo "<h1 class='text-center'>Update Member</h1>";
	  			echo "<div class='container'>";
	  			$user=$_POST['username'];
	  			$full=$_POST['full'];
	  			$email=$_POST['email'];
	  			$id=$_POST['userid'];
	  			$pass='';
	  			$error_arr= array();
	  			if(!empty($user)&&!empty($full)&&!empty($email))
	  			{
	  				if(empty($_POST['newpassword']))
	  				{
	  					$pass= $_POST['oldpassword'];
	  				}
	  				else
	  				{
	  					$pass=md5($_POST['newpassword']);
	  				}
	  				if(strlen($user)>20)
	  				{
	  					$error_arr[]="The username should't be bigger than 20 char";
	  				}
	  				if(strlen($user)<4)
	  				{
	  					$error_arr[]="The username should't be less than 4 char";
	  				}
	  				foreach ($error_arr as  $value) {
	  					echo "<div class='alert alert-danger'>". $value."</div>";
	  				}
	  				if(empty($error_arr))
	  				{
							$stmt=$con->prepare("SELECT * FROM users WHERE username=? AND userId !=?");
							$stmt->execute(array($user,$id));
							$count=$stmt->rowCount();
							if($count==1)
							{
								echo "<div class='alert alert-danger'>this user exist before</div>";
								redirect(2,"back");
							}else
							{
								$stmt=$con->prepare("UPDATE users SET username=? , Email=? , fullname=? , password=? WHERE userId=?");
								$stmt->execute(array($user,$email,$full,$pass,$id));
								echo "<div class='alert alert-success'>".$stmt->rowCount()."Record Updated</div>";
								redirect(2,"back");
							}
	  					

	  				}
	  				
	  			}
	  		}
	  		else
	  		{
	  			echo "<div class='alert alert-danger'>you can't browse this page directly</div>"."<br>";
	  					
	  			redirect(2,"back");
	  		}
	  		
	  		echo "</div>";
	  	}
	  	else if($do=="Insert")
	  	{
	  		
	  		if(isset($_POST['username'])&&isset($_POST['full'])&&isset($_POST['email']))
	  		{
	  			echo "<h1 class='text-center'>Insert Member</h1>";
	  			echo "<div class='container'>";
	  			$user=$_POST['username'];
	  			$full=$_POST['full'];
	  			$email=$_POST['email'];
					$pass=$_POST['password'];
					

					$avatarName=$_FILES['avatar']['name'];
					$avatarSize=$_FILES['avatar']['size'];
					$avatarTmp=$_FILES['avatar']['tmp_name'];
					$avatartype=$_FILES['avatar']['type'];

					$avatarAllowedExtension=array("jpeg","jpg","png","gif");
					$avatarExtension=strtolower(end(explode(".",$avatarName)));
					

	  			$error_arr= array();
	  			if(!empty($user)&&!empty($full)&&!empty($email) &&!empty($pass))
	  			{
	  				if(strlen($user)>20)
	  				{
	  					$error_arr[]="The username should't be bigger than 20 char";
	  				}
	  				if(strlen($user)<4)
	  				{
	  					$error_arr[]="The username should't be less than 4 char";
	  				}
	  				if(strlen($pass)<4)
	  				{
	  					$error_arr[]="The password should't be less than 4 char";
	  				}
	  				if(strlen($pass)>20)
	  				{
	  					$error_arr[]="The password should't be bigger than 20 char";
						}
						if(!in_array($avatarExtension,$avatarAllowedExtension))
						{
							$error_arr[]="this file is not acceptable";
						}
	  				foreach ($error_arr as  $value) {
	  					echo "<div class='alert alert-danger'>". $value."</div>";
	  				}
	  				if(empty($error_arr))
	  				{
							$avatar=rand(0,100000).'_'.$avatarName;
							move_uploaded_file($avatarTmp,"uploads\avatar\\".$avatar);
	  					if(checkitem("username","users",$user)>0)
	  					{
	  						echo "<div class='alert alert-danger'>sorry this username exist before</div>";
	  						redirect(2,"back");
	  					}
	  					else
	  					{
	  						$pass=md5($_POST['password']);
	  						$stmt=$con->prepare("INSERT INTO users(username,Email,fullname,password,RegStatus,Date,avatar) VALUES (?, ?, ?, ?,1,now(),?)");
	  						$stmt->execute(array($user,$email,$full,$pass,$avatar));
	  						echo "<div class='alert alert-success'>".$stmt->rowCount()."Record Inserted</div>";
	  					}
	  					
	  					redirect(2,"back","members.php");
	  					
	  				}
	  				
	  			}
	  		}else
	  		{	echo "<div class='alert alert-danger'>you can't browse this page directly</div>"."<br>";
	  					
	  			redirect(2,"back");
	  		}
	  		
	  		echo "</div>";
	  	}
	  	elseif($do=="Delete")
	  	{
	  		echo "<div class='container'>";
	  		echo "<h1 class='text-center'>Delete Member</h1>";
	  		$userid=isset($_GET['userid'])&&is_numeric($_GET['userid'])? intval($_GET['userid']) : 0;
	  		if(checkitem("userId","users",$userid)==1)
	  		{
	  			$stmt=$con->prepare("DELETE FROM users WHERE userId=?");
	  			$stmt->execute(array($userid));
	  			echo "<div class='alert alert-success'>".$stmt->rowCount()."Record Deleted</div>";
	  			redirect(2,"members.php","members.php");	
	  		}else
	  		{
	  			echo "<div class='alert alert-danger'>there is no such id</div>";
	  			redirect(2,"members.php","members.php");
	  		}
	  		
	  		echo "</div>";

			}
			elseif($do=="Activate")
			{
				echo "<div class='container'>";
	  		echo "<h1 class='text-center'>Activate Member</h1>";
	  		$userid=isset($_GET['userid'])&&is_numeric($_GET['userid'])? intval($_GET['userid']) : 0;
	  		if(checkitem("userId","users",$userid)==1)
	  		{
	  			$stmt=$con->prepare("UPDATE  users SET RegStatus=1 WHERE userId=?");
	  			$stmt->execute(array($userid));
	  			echo "<div class='alert alert-success'>".$stmt->rowCount()."Record Updated</div>";
	  			redirect(2,"members.php","members.php?do=Manage&page=pending");	
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

