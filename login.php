<?php 
        /*start login*/
    ob_start();
    session_start();
    $title="login/signup";
      
      if(isset($_SESSION['name']))
	  {
	  	header("location:index.php");
      }
      include "ini.php";
      if(isset($_POST['login']))
      {
          
         
          $name=filter_var($_POST['name'], FILTER_SANITIZE_STRING);
          $password= $_POST['password'];
          if(!empty($name)&&!empty($password))
          {
              $password=md5($_POST['password']);
              $stmt = $con->prepare("SELECT * from users WHERE username= ? AND password= ?");
              $stmt->execute(array( $name,$password));
              $r=$stmt->fetch();
              $count=$stmt->rowCount();
              if($count>0)
              {
                    $_SESSION['name']=$name;
                    $_SESSION['myid']=$r['userId'];  
                    header("location:index.php");
                    exit();
              }
          }
          else
          {
              echo "please enter the username and password";
          }
      }else
      {
          
          if(isset($_POST['username']) && isset($_POST['password']))
          {
            $username=filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            $full=filter_var($_POST['full'], FILTER_SANITIZE_STRING);
            $email=filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $error_arr= array();
            
	  			if(!empty($username)&&!empty($full)&&!empty($email))
	  			{

                    if(empty($_POST['password']))
                    {
                        $error_arr[]="the password should't be empty";
                    }
                    $password1=md5($_POST['password']);
                    $password2=md5($_POST['password2']);        
	  				if(strlen($username)>20)
	  				{
	  					$error_arr[]="The username should't be bigger than 20 char";
	  				}
	  				if(strlen($username)<4)
	  				{
	  					$error_arr[]="The username should't be less than 4 char";
	  				}
                    if($password1 != $password2)
                    {
                        $error_arr[]="The password dosen't match";
                    }
                    if(!filter_var($email,FILTER_VALIDATE_EMAIL) )
                    {
                        $error_arr[]="email is not valid";
                    }
                    if(empty($error_arr))
	  				{
	  					if(checkitem("username","users",$username) > 0)
	  					{
                            $error_arr[]="this username exist before";
	  						
	  					}
	  					else
	  					{
	  						$stmt=$con->prepare("INSERT INTO users(username,Email,fullname,password,RegStatus,Date) VALUES (?, ?, ?, ?,0,now())");
	  						$stmt->execute(array($username,$email,$full,$password1));
	  						$successmsg="Congratulation you have registerd successfully";
	  					}
	  				}
                }
            
            
          }
          
      }
      ?>

    <div class="container log">
        <h1 class="text-center">
            <span class="login active" data-class="login">LogIn </span>| 
            <span class="signup" data-class="signup">SignUp</span>
        </h1>
        <!--start loginform-->
        <form class="text-center login" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="name"  placeholder="Enter your Username" autocomplete="off" required>
            </div>
            <div class="form-group">
                
                <input type="password" class="form-control" name="password"  placeholder="Enter Your Password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block" name="login">LogIn</button>
        </form>
        <!--end loginform-->
        <!--start signup form-->        
        <form class="text-center signup" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="username"  placeholder="Enter your Username" autocomplete="off" 
                       pattern=".{4,}" title="UserName must be 4 char or more"     required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="full"  placeholder="Enter your fullname" autocomplete="off" required>
            </div>
            <div class="form-group">
                
                <input type="password" class="form-control" name="password"  placeholder="Enter Your Password" 
                       pattern=".{6,}" title="password must be 6 char or more" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password2"  placeholder="Enter Your Password again" required>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email"  placeholder="Enter Your Email" required>
            </div>
            <button type="submit" class="btn btn-success btn-block" name="signup">SignUp</button>
        </form>
        <!--end signup form-->
            <div class="errors text-center">
                <?php
                    if(!empty($error_arr))
                    {
                        foreach ($error_arr as  $value) {
                            echo "<div class='msg error'>". $value."</div>";
                        }
                    }
                    if(isset($successmsg))
                    {
                        echo "<div class='msg success'>". $successmsg."</div>";
                    }
                ?>
            </div>
    </div>
   

	
<?php ob_end_flush(); include  "includes/templates/footer.php";?>