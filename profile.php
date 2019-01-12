<?php 
      ob_start();
      session_start();
	  $title="AMNCommerce";
      include "ini.php";
      if(isset($_SESSION['name']))
      {
          $getuser=$con->prepare("SELECT * FROM users WHERE username=?");
          $getuser->execute(array($_SESSION['name']));
          $user=$getuser->fetch();
?>
        <h1 class="text-center">My Profile</h1>
        <div class="information block">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        My information
                    </div>
                    <div class="card-body">
                        <p class="card-text"><span>Name</span>:<?php echo $user['username']?></p>
                        <p class="card-text"><span>Email</span>:<?php echo $user['Email']?></p>
                        <p class="card-text"><span>Full Name</span>:<?php echo $user['fullname']?></p>
                        <p class="card-text"><span>Register Date</span>:<?php echo $user['Date']?></p>
                        <p class="card-text"><span>Favourite Category</span>:Ahmed</p>
                        <a class="btn btn-danger" href="#">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="my-Ads block">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        My Ads
                    </div>
                    <div class="card-body">
                        <div class="row">
                    <?php
                        $all=Getall("*","items","where Member_Id={$user['userId']}","","item_ID");
                        if(!empty($all))
                        {
                            
                            foreach ($all as $value)
                            {
                                echo "<div class='col-sm-6 col-md-3'>";
                                    echo '<div class="card card-item">';
                                        echo '<img class="card-img-top" src="layout\images\avatar2.png">';
                                        if($value['Approve']==0)
                                        {
                                            echo '<span class="approval-status">Wating Approval</span>';
                                        }
                                        echo '<span class="price">$'.$value['Price'].'</span>';
                                        echo '<div class="card-body">';
                                            echo '<h5 class="card-title"><a href=items.php?itemid='.$value['item_ID'].'>'.$value['Name'].'</a></h5>';
                                            echo '<p class="card-text">'.$value['Description'].'</p>';
                                            
                                            
                                        echo '</div>';
                                        echo '<p class="card-text date">'.$value['Add_Date'].'</p>';
                                    echo '</div>';
                                echo "</div>";
                            }
                        }
                        else
                            echo "<p>their is no Ads to show <a href='newad.php'>New Ad</a> </p>";
                        
                    ?>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-comments block">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        My Comments
                    </div>
                    <div class="card-body">
                    <?php
                        $all=Getall("*","comments","WHERE user_id= {$user['userId']}","","c_id");
                        if(!empty($all))
                        {
                            foreach ($all as $value)
                            {
                                echo "<p>".$value['comment']."</p>";
                            }    
                        }
                        else
                            echo "<p>their is no comments to show </p>";
                        
                    ?>
                    </div>
                </div>
            </div>
        </div>

<?php 
      }else
      {
          header("Location:login.php");
          exit();
      }
include "includes/templates/footer.php";
      ob_end_flush();
 ?>