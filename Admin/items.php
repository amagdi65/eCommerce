<?php
session_start();
	  if(isset($_SESSION['Username']))
	  {
	  	$title="Items";
	  	include "ini.php";
	  	$do=isset($_GET['do'])? $_GET['do']:"Manage";
	  	if($do=="Manage") {	
        $stmt=$con->prepare("SELECT items.*, categories.Name AS cat_name ,users.username FROM items 
        INNER JOIN categories ON categories.ID=items.Cat_Id
        INNER JOIN users ON users.userId=items.Member_Id");
          $stmt->execute();
          $row=$stmt->fetchAll();


      ?>

          <h1 class="text-center">Manage Items</h1>
          <div class="container">
              <table class="table table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th scope="col" class="text-center">#ID</th>
                  <th scope="col" class="text-center">Name</th>
                  <th scope="col" class="text-center">Description</th>
                  <th scope="col" class="text-center">Price</th>
                  <th scope="col" class="text-center">Adding Date</th>
                  <th scope="col" class="text-center">Category</th>
                  <th scope="col" class="text-center">Member</th>
                  <th scope="col" class="text-center">Control</th>
                </tr>
              </thead>
              <tbody>
                  <?php
                      foreach ($row as $value) {
                          echo "<tr>";
                          echo "<th class='text-center' scope='row'>".$value['item_ID']."</th>";
                          echo "<td class='text-center'>".$value['Name']."</td>";
                          echo "<td class='text-center'>".$value['Description']."</td>";
                          echo "<td class='text-center'>".$value['Price']."</td>";
                          echo "<td class='text-center'>".$value['Add_Date']."</td>";
                          echo "<td class='text-center'>".$value['cat_name']."</td>";
                          echo "<td class='text-center'>".$value['username']."</td>";
                        echo "<td class='text-center control'>
                          <a href='items.php?do=Edit&itemid=".$value['item_ID']."'class='btn btn-success'><i class='far fa-edit'></i> Edit</a>
                          <a href='items.php?do=Delete&itemid=".$value['item_ID']."' class='btn btn-danger confirm'><i class='far fa-trash-alt'></i> Delete</a>";
                          if($value['Approve']==0)
									{
									echo "<a href='items.php?do=Approve&itemid=".$value['item_ID']."' class='btn btn-info '><i class='fas fa-check-circle'></i> Approve</a>";
									}      
                          echo"</td>";
                          echo "</tr>";
                                      
                
                  
                      }
                  ?>
             
              </tbody>
            </table>
          <a href='items.php?do=Add' class="btn btn-primary add"><i class="fas fa-plus"></i> New Item</a>
          </div>
      <?php
    }
        elseif ($do =="Edit") {
            $itemid=isset($_GET['itemid'])&&is_numeric($_GET['itemid'])? intval($_GET['itemid']) : 0;
            $stmt= $con->prepare("SELECT * FROM items Where item_ID=?");
            $stmt->execute(array($itemid));
            $row1= $stmt->fetch();
            $count=$stmt->rowCount();
            if($count>0)
            {


            ?>
            <h1 class="text-center">Edit item</h1>
            <div class="container">
            <form method="POST" action="items.php?do=Update">
                    <div class="form-group row">
                        <label  class="col-sm-2 col-md-offset-6 col-form-label">Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text"  class="form-control" id="staticEmail" value=<?php echo $row1['Name']?> autocomplete="off" name="Name" required >
                            <input type="text" name="itemid" hidden value=<?php echo $row1['item_ID']?>>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label  class="col-sm-2 col-md-offset-6 col-form-label">Description</label>
                        <div class="col-sm-10 col-md-6">
                        <input type="text" class="form-control" value=<?php echo $row1['Description']?> name="Describe" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-md-offset-6 col-form-label">Price</label>
                        <div class="col-sm-10 col-md-6">
                        <input type="text" class="form-control" value=<?php echo $row1['Price']?> autocomplete="off" name="price" required >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-md-offset-6 col-form-label">Country</label>
                        <div class="col-sm-10 col-md-6">
                        <input type="text" class="form-control" value=<?php echo $row1['Country_Made']?> autocomplete="off" name="country" required >
                        </div>
                    </div>
                    <div class="form-group row">
                            <label class="col-sm-2 col-md-offset-6 col-form-label">Status</label>
                            <div class="col-sm-10 col-md-6">
                                <select name="status" required class="form-control ">
                                    <option value="0"<?php if($row1['Status']==0) echo "selected"?>>...</option>
                                    <option value="1"<?php if($row1['Status']==1) echo "selected"?>>New</option>
                                    <option value="2"<?php if($row1['Status']==2) echo "selected"?>>Like New</option>
                                    <option value="3"<?php if($row1['Status']==3) echo "selected"?>>Old</option>
                                </select>
                            </div>
                    </div>
                    <div class="form-group row">
                            <label class="col-sm-2 col-md-offset-6 col-form-label">Member</label>
                            <div class="col-sm-10 col-md-6">
                                <select name="user" required class="form-control ">
                                    <option value="0">...</option>
                                    <?php 
                                        $stmt=$con->prepare("SELECT * FROM users");
                                        $stmt->execute();
                                        $val=$stmt->fetchAll();
                                        foreach($val as $user)
                                        {
                                            echo "<option value='".$user['userId']."'";
                                            if($row1['Member_Id']==$user['userId'])
                                            {
                                                echo "selected";
                                            }
                                        echo ">".$user['username']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                    </div>
                    <div class="form-group row">
                            <label class="col-sm-2 col-md-offset-6 col-form-label">Category</label>
                            <div class="col-sm-10 col-md-6">
                                <select name="category" required class="form-control ">
                                    <option value="0">...</option>
                                    <?php 
                                        $stmt=$con->prepare("SELECT * FROM categories");
                                        $stmt->execute();
                                        $val=$stmt->fetchAll();
                                        foreach($val as $user)
                                        {
                                            echo "<option value='".$user['ID']."'";
                                            if($row1['Cat_Id']==$user['ID'])
                                            {
                                                echo "selected";
                                            }
                                        echo ">".$user['Name']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-sm-2 offset-md-2"></div>
                        <div class="col-sm-8">
                            <input type="submit" class="btn btn-primary btn-lg"  value="Save">
                        </div>
                    </div>
                </form>
                <?php
                $stmt=$con->prepare("SELECT comments.*,users.username FROM comments 
                INNER JOIN users ON users.userId=comments.user_id WHERE item_id=?"  );
	  		$stmt->execute(array($itemid));
	  		$row1=$stmt->fetchAll();
            if(!empty($row1)){
	  	?>
                
	  		<h1 class="text-center">Manage [ <?php echo $row1['Name'] ?>] comments</h1>
	  		
	  			<table class="table table-bordered">
				  <thead class="thead-dark">
				    <tr>
				      
				      <th scope="col" class="text-center">Comment</th>
				      <th scope="col" class="text-center">UserName</th>
				      <th scope="col" class="text-center">Added Date</th>
				      <th scope="col" class="text-center">Control</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php
				  		foreach ($row1 as $value) {
				  			echo "<tr>";
				      		
				      		echo "<td class='text-center'>".$value['comment']."</td>";
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

                    <?php }?>
            </div>
        <?php

            }
            else
            {
                echo "<div class='alert alert-danger'>there is no such id</div>";
            } 
	  		
        }
        elseif ($do =="Add") {
            ?>
            <h1 class="text-center">Add New Item</h1>
            <div class="container items">
                <form method="POST" action="items.php?do=Insert">
                    <div class="form-group row">
                        <label  class="col-sm-2 col-md-offset-6 col-form-label">Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text"  class="form-control" id="staticEmail" placeholder="Name Of The Item" autocomplete="off" name="Name" required >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label  class="col-sm-2 col-md-offset-6 col-form-label">Description</label>
                        <div class="col-sm-10 col-md-6">
                        <input type="text" class="form-control" placeholder="Describe The Item" name="Describe" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-md-offset-6 col-form-label">Price</label>
                        <div class="col-sm-10 col-md-6">
                        <input type="text" class="form-control" placeholder="Price Of The Item" autocomplete="off" name="price" required >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-md-offset-6 col-form-label">Country</label>
                        <div class="col-sm-10 col-md-6">
                        <input type="text" class="form-control" placeholder="Made In (#Egypt)" autocomplete="off" name="country" required >
                        </div>
                    </div>
                    <div class="form-group row">
                            <label class="col-sm-2 col-md-offset-6 col-form-label">Status</label>
                            <div class="col-sm-10 col-md-6">
                                <select name="status" required class="form-control ">
                                    <option value="0">...</option>
                                    <option value="1">New</option>
                                    <option value="2">Like New</option>
                                    <option value="3">Old</option>
                                </select>
                            </div>
                    </div>
                    <div class="form-group row">
                            <label class="col-sm-2 col-md-offset-6 col-form-label">Member</label>
                            <div class="col-sm-10 col-md-6">
                                <select name="user" required class="form-control ">
                                    <option value="0">...</option>
                                    <?php 
                                        $stmt=$con->prepare("SELECT * FROM users");
                                        $stmt->execute();
                                        $val=$stmt->fetchAll();
                                        foreach($val as $user)
                                        {
                                            echo "<option value='".$user['userId']."'>".$user['username']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                    </div>
                    <div class="form-group row">
                            <label class="col-sm-2 col-md-offset-6 col-form-label">Category</label>
                            <div class="col-sm-10 col-md-6">
                                <select name="category" required class="form-control ">
                                    <option value="0">...</option>
                                    <?php 
                                        $stmt=$con->prepare("SELECT * FROM categories");
                                        $stmt->execute();
                                        $val=$stmt->fetchAll();
                                        foreach($val as $user)
                                        {
                                            echo "<option value='".$user['ID']."'>".$user['Name']."</option>";
                                        }
                                    ?>
                                </select>
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
        elseif($do=="Update") {
            echo "<h1 class='text-center'>Update Item</h1>";
            echo "<div class='container'>";
            $name=$_POST['Name'];
            $description=$_POST['Describe'];
            $price=$_POST['price'];
            $country=$_POST['country'];
            $status=$_POST['status'];
            $member=$_POST['user'];
            $cat=$_POST['category'];
            $itemsid=$_POST['itemid'];
            $error_arr= array();
            if(!empty($name)&&!empty($description)&&!empty($price) &&!empty($country))
            {
                
                if(strlen($name)<4)
                {
                    $error_arr[]="The name should't be less than 4 char";
                }
                if($status==0)
                {
                    $error_arr[]="you should choose status";
                }
                if($member==0)
                {
                    $error_arr[]="you should choose Member";
                }
                if($cat==0)
                {
                    $error_arr[]="you should choose Category";
                }
                
                
                if(empty($error_arr))
                {
                    
                    $stmt=$con->prepare("UPDATE items  SET 
                                                        Name=? , 
                                                        Description=? , 
                                                        Price=? , 
                                                        Country_Made=?,
                                                        Status=?, 
                                                        Cat_Id=?,
                                                        Member_Id=?
                                                        WHERE item_ID=?");
                    
                    $stmt->execute(array($name,$description,$price,$country,$status,$cat,$member,$itemsid));
                    
                    echo "<div class='alert alert-success'>".$stmt->rowCount()."Record Updated</div>";
                    redirect(2,"back","items.php");
                    
                }
                else
                {
                    foreach ($error_arr as  $value) {
                        echo "<div class='alert alert-danger'>". $value."</div>";
                        redirect(2,"back","items.php");
                    }
                }
                
            }
            echo "</div>";
	  		
	  	
        }	
        elseif($do=="Insert") {
            echo "<h1 class='text-center'>Insert Item</h1>";
            echo "<div class='container'>";
            $name=$_POST['Name'];
            $description=$_POST['Describe'];
            $price=$_POST['price'];
            $country=$_POST['country'];
            $status=$_POST['status'];
            $member=$_POST['user'];
            $cat=$_POST['category'];
            $error_arr= array();
            if(!empty($name)&&!empty($description)&&!empty($price) &&!empty($country))
            {
                
                if(strlen($name)<4)
                {
                    $error_arr[]="The name should't be less than 4 char";
                }
                if($status==0)
                {
                    $error_arr[]="you should choose status";
                }
                if($member==0)
                {
                    $error_arr[]="you should choose Member";
                }
                if($cat==0)
                {
                    $error_arr[]="you should choose Category";
                }
                
                
                if(empty($error_arr))
                {
                    
                    $stmt=$con->prepare("INSERT INTO items(Name,Description,Price,Add_Date,Country_Made,Status,Cat_Id,Member_Id) VALUES (?,?,?,now(),?,?,?,?)");
                    $stmt->execute(array($name,$description,$price,$country,$status,$cat,$member));
                    echo "<div class='alert alert-success'>".$stmt->rowCount()."Record Inserted</div>";
                    redirect(2,"back","items.php");
                    
                }
                else
                {
                    foreach ($error_arr as  $value) {
                        echo "<div class='alert alert-danger'>". $value."</div>";
                        redirect(2,"back");
                    }
                }
                
            }
            echo "</div>";
        } 
         
        elseif($do=="Delete") {
            echo "<div class='container'>";
            echo "<h1 class='text-center'>Delete Member</h1>";
            $itemsid=isset($_GET['itemid'])&&is_numeric($_GET['itemid'])? intval($_GET['itemid']) : 0;
            if(checkitem("item_ID","items",$itemsid)==1)
            {
                $stmt=$con->prepare("DELETE FROM items WHERE item_ID=?");
                $stmt->execute(array($itemsid));
                echo "<div class='alert alert-success'>".$stmt->rowCount()."Record Deleted</div>";
                redirect(2,"blabla","items.php");	
            }else
            {
                echo "<div class='alert alert-danger'>there is no such id</div>";
                redirect(2,"blabla","items.php");	
            }
            
            echo "</div>";
	  		
        }
        elseif($do=="Approve") {
            echo "<div class='container'>";
	  		echo "<h1 class='text-center'>Activate Member</h1>";
	  		$itemid=isset($_GET['itemid'])&&is_numeric($_GET['itemid'])? intval($_GET['itemid']) : 0;
	  		if(checkitem("item_ID","items",$itemid)==1)
	  		{
	  			$stmt=$con->prepare("UPDATE  items SET Approve=1 WHERE item_ID=?");
	  			$stmt->execute(array($itemid));
	  			echo "<div class='alert alert-success'>".$stmt->rowCount()."Record Updated</div>";
	  			redirect(2,"back");	
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