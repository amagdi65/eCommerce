<?php 
	  session_start();
	  $nonavbar="";
	  $title="Login";
	  include "ini.php";
	  if(isset($_SESSION['Username']))
	  {
	  	header("location:dashboard.php");
	  }

      if(isset($_POST['user']) && isset($_POST['pass']))
      {
          $username=$_POST['user'];
          $password=md5($_POST['pass']);
          if(!empty($username)&&!empty($password))
          {
              $stmt = $con->prepare("SELECT username,password,userId from users WHERE username= ? AND password= ? AND GroupID=1");
              $stmt->execute(array( $username,$password));
              $row=$stmt->fetch();
              $count=$stmt->rowCount();
              if($count>0)
              {
              		$_SESSION['Username']=$username;
              		$_SESSION['ID']=$row['userId'];
              		header("location:dashboard.php");
                    exit();
              }
          }
          else
          {
              echo "please enter the username and password";
          }
      }

?>
    <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <h3 class="text-center">Admin Login</h3>
        <input type="text" class="form-control" name="user" placeholder="username" autocomplete="off"/>
        <input type="password" class="form-control" name="pass" placeholder="password" autocomplete="new-password"/>
        <input type="submit" class="btn btn-primary btn-block" value="login"/>
    </form>
	
<?php include "includes/templates/footer.php";?>