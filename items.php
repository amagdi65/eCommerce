<?php 
      ob_start();
      session_start();
	$title="Show Item";
      include "ini.php";
      $itemid=isset($_GET['itemid'])&&is_numeric($_GET['itemid'])? intval($_GET['itemid']) : 0;
      $stmt=$con->prepare("SELECT items.*, categories.Name AS cat_name ,users.username FROM items 
        INNER JOIN categories ON categories.ID=items.Cat_Id
        INNER JOIN users ON users.userId=items.Member_Id WHERE Item_ID =? AND Approve=1");
      $stmt->execute(array($itemid));
      $row1= $stmt->fetch();
      $count=$stmt->rowCount();
      if($count>0)
      {
      
      
?>
        <h1 class="text-center"><?php echo $row1['Name'] ?></h1>
        <div class="container">
            <div class="row">
                  <div class="col-md-3 blabla">
                        <img class="card-img-top img-fluid mx-auto" src="layout\images\avatar2.png">
                  </div>
                  <div class="col-md-9 item-info">
                        <h3><?php echo $row1['Name']?></h3>
                        <p><?php echo $row1['Description']?></p>
                        <ul class="list-unstyled">
                              <li>
                                    <i class="far fa-calendar-alt fa-lg">
                                    </i>
                                    <span> Aded Date </span>:
                                    <?php echo $row1['Add_Date']?>
                              </li>
                              <li>
                                    <i class="fas fa-hand-holding-usd fa-lg">
                                    </i><span>Price</span>: $
                                    <?php echo $row1['Price']?>
                              </li>
                              <li>
                                    <i class="fas fa-plane">
                                    </i><span>Made In</span> :
                                    <?php echo $row1['Country_Made']?>
                              </li>
                              <li>
                                    <i class="fas fa-tags">
                                    </i><span>Category </span> :
                                    <a href="categories.php?pageid=<?php echo $row1['Cat_Id']?>&pagename=<?php echo $row1['cat_name']?>"><?php echo $row1['cat_name']?></a>
                              </li>
                              <li>
                              <i class="fas fa-users">
                              </i>
                                    <span>Aded By </span>:
                                    <a href="#"><?php echo $row1['username']?></a>
                                    
                              </li>
                        </ul>
                        
                  </div>
            </div>
            <hr class="custom-hr">
            <?php
                  if(isset($_SESSION['name']))
                  {

            ?>
            <div class="row">
                  <div class="offset-md-3">
                        <div class="add-comment">
                              <h3>Add Your Comment</h3>
                              <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <textarea placeholder="Leave your comment" name="comm" required></textarea>
                                    <input class="btn btn-primary btn-lg" type="submit" value="Post">
                              </form>
                        </div>
                  </div>
            </div>
                  <?php
                  if(isset($_POST['comm']))
                  {
                        $comment=filter_var($_POST['comm'],FILTER_SANITIZE_STRING);
                        if(!empty($comment))
                        {     
                              echo $_SESSION['myid'];
                              $stmt=$con->prepare("INSERT INTO comments(comment,comment_date,item_id,user_id)
                                                     VALUES(?,now(),?,?)");
                              $stmt->execute(array($comment,$row1['item_ID'],$_SESSION['myid']));
                              echo "<div class='alert alert-success'>Added</div>";
                              
                        }      
                  }
                  
            }
                  else 
                        echo "you should be <a href='login.php'>Login</a> or <a href='login.php'>Register</a> To Add Comment";
                  
                  ?>
                  <?php
                        $stmt=$con->prepare("SELECT comments.*,users.username FROM comments 
                        INNER JOIN users ON users.userId=comments.user_id WHERE status=1 AND item_id=?");
                        $stmt->execute(array($row1['item_ID']));
                        $row=$stmt->fetchAll();
                  
                        ?>
            <hr class="custom-hr">
            <?php
                   foreach($row as $value)
                   {?>     
                   <div class="comment-box">
                        <div class='row'>
                              <div class='col-md-2'>
                                    <img class="img-fluid rounded-circle" src="layout\images\avatar2.png">
                                    <div class="text-center"><?php echo $value['username']?></div>
                              </div>
                              <div class='col-md-10'>
                                    <p class="lead"><?php echo $value['comment'] ?></p>
                              </div>
                        </div>
                        
                   </div>
                   <hr class="custom-hr">
                   <?php
                   }
            ?>
            
        </div>        

<?php 

      }else
      {
            
           echo "<div class='alert alert-danger'>this is wrong id or this item not aproved yet</div>";
           redirect(2,"back");
      }
      
include "includes/templates/footer.php";
      ob_end_flush();
 ?>