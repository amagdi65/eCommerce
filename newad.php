<?php 
      ob_start();
      session_start();
	  $title="New Ad";
      include "ini.php";
      if(isset($_SESSION['name']))
      {
          $getuser=$con->prepare("SELECT * FROM users WHERE username=?");
          $getuser->execute(array($_SESSION['name']));
          $user=$getuser->fetch();
          if(isset($_POST['Name'])&&isset($_POST['Describe'])&&isset($_POST['category']))
          {
            $name=filter_var($_POST['Name'],FILTER_SANITIZE_STRING);
            $description=filter_var($_POST['Describe'],FILTER_SANITIZE_STRING);
            $status=filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
            $price=filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
            $country=filter_var($_POST['country'],FILTER_SANITIZE_STRING);
            $cat=filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
           
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
                
                    if($cat==0)
                    {
                        $error_arr[]="you should choose Category";
                    }
                    
                    
                    if(empty($error_arr))
                    {
                        
                        $stmt=$con->prepare("INSERT INTO items(Name,Description,Price,Add_Date,Country_Made,Status,Cat_Id,Member_Id) VALUES (?,?,?,now(),?,?,?,?)");
                        $stmt->execute(array($name,$description,$price,$country,$status,$cat,$user['userId']));
                        $successmsg="The Item Has been Added successfuly";
                        
                    }

                }   
            }
?>
        <h1 class="text-center">Create New Item</h1>
        <div class="create-ad block">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        Create New Item
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                            <form method="POST" action=<?php echo $_SERVER['PHP_SELF']?>>
                                <div class="form-group row">
                                    <label  class="col-sm-2 col-md-offset-6 col-form-label">Name</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text"  class="form-control livename" data-live="nname" id="staticEmail" placeholder="Name Of The Item" autocomplete="off" name="Name" required >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label  class="col-sm-2 col-md-offset-6 col-form-label">Description</label>
                                    <div class="col-sm-10 col-md-6">
                                    <input type="text" class="form-control livedesc" data-live="ddesc" placeholder="Describe The Item" name="Describe" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-md-offset-6 col-form-label">Price</label>
                                    <div class="col-sm-10 col-md-6">
                                    <input type="text" class="form-control liveprice" data-live="pprice" placeholder="Price Of The Item" autocomplete="off" name="price" required >
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
                                        <label class="col-sm-2 col-md-offset-6 col-form-label">Category</label>
                                        <div class="col-sm-10 col-md-6">
                                            <select name="category" required class="form-control ">
                                                <option value="0">...</option>
                                                <?php 
                                                    
                                                    $val=Getall("*","categories","","","ID");
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
                                        <input type="submit" class="btn btn-primary btn-lg"  value="Add Item">
                                    </div>
                                </div>
                            </form>
                            </div>
                            <div class="col-md-4"> 
                                <div class="card card-item livepreview">
                                    <img class="card-img-top" src="layout\images\avatar2.png">
                                    <span class="price pprice">$0</span>
                                    <div class="card-body">
                                        <h5 class="card-title nname">item</h5>
                                        <p class="card-text ddesc" >description</p>
                                        
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div>
                    <?php
                            if(!empty($error_arr))
                            {
                                foreach ($error_arr as  $value) {
                                    echo "<div class='alert alert-danger msg'>". $value."</div>";
                                }
                            }
                            if(isset($successmsg))
                            {
                                echo "<div class='alert alert-success msg'>". $successmsg."</div>";
                            }
                        ?>
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