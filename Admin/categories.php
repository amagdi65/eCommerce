<?php


    ob_start();
    session_start();
    if(isset($_SESSION['Username']))
    {
        include "ini.php";
        $title="Categories";
        $do=(isset($_GET['do']))? $_GET['do']:"Manage";
        if($do=="Manage")
        {
            $sort='ASC';
            $sort_arr = array('ASC','DESC');
            if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_arr))
            {
                $sort=$_GET['sort'];
            }
           $stmt=$con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
           $stmt->execute();
           $result=$stmt->fetchAll();
        ?>
            <h1 class="text-center ">Manage Category</h1>
            <div class="container categories">
                <div class="card">
                    <div class="card-header">
                    Manage Category
                        <div class="float-right" >
                            Oredering : [
                            <a <?php if($sort=="ASC") echo "class='Active'"?> href="?sort=ASC"> ASC</a> |
                            <a <?php if($sort=="DESC") echo "class='Active'"?> href="?sort=DESC">DESC ]</a>
                        </div>
                        
                    </div>
                    
                    <div class="card-body">
                        <?php
                            foreach($result as $value)
                            {   echo "<div class='cat'>";
                                    echo "<div class='hidden-bottom'>
                                        <a href='categories.php?do=Edit&catid=".$value['ID']."'class='btn btn-success btn-xs'><i class='far fa-edit'></i> Edit</a>
                                        <a href='categories.php?do=Delete&catid=".$value['ID']."' class='btn btn-danger btn-xs confirm'><i class='far fa-trash-alt'></i> Delete</a> 
                                    </div>";
                                    echo "<h3>".$value['Name']."</h3>";
                                    echo "<div class='slide'>";
                                        echo "<p>";
                                        if($value['Description']=="") {echo "this Category has no Describtion";} else {echo $value['Description'];}
                                        echo "</p>";
                                        if($value['Visibility']==1) echo "<span class='vis'><i class='fas fa-eye fa-xs'></i> Hidden</span>";
                                        if($value['Allow_Comment']==1) echo "<span class='comment'><i class='fas fa-user-times fa-xs'></i> Comment Disabled "."</span>";
                                        if($value['Allow_Ads']==1) echo "<span class='adv'><i class='fas fa-user-times fa-xs'></i> Advertises Disabled"."</span>";
                                    echo "</div>";
                                echo "</div>";
                                echo "<hr>";
                            }
                        ?>
                    </div>
                </div>
                <a href='categories.php?do=Add' class="btn btn-primary new-cat"><i class="fas fa-plus"></i> New Category</a>
            </div>

        <?php
        }

        elseif ($do =="Add") {
            //add Category
         ?>
            <h1 class="text-center">Add New Category</h1>
            <div class="container">
                <form method="POST" action="categories.php?do=Insert">
                    <div class="form-group row">
                        <label  class="col-sm-2 col-md-offset-6 col-form-label">Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text"  class="form-control" id="staticEmail" placeholder="Name Of The Category" autocomplete="off" name="Name" required >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label  class="col-sm-2 col-md-offset-6 col-form-label">Description</label>
                        <div class="col-sm-10 col-md-6">
                        <input type="text" class="form-control" placeholder="Describe The Category" name="Describe" autocomplete="off" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-md-offset-6 col-form-label">Ordering</label>
                        <div class="col-sm-10 col-md-6">
                        <input type="text" class="form-control" placeholder="Number To Arrange The Categories" autocomplete="off" name="order" >
                        </div>
                    </div>
                    <div class="form-group form-group-lg row">
                        <label for="inputPassword" class="col-sm-2  col-form-label">Visible</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input type="radio" id="yup-vis"  name="visible" value="0" checked>
                                <label for="yup-vis">Yes</label>
                            </div>
                            <div>
                                <input type="radio" id="nope-vis"  name="visible" value="1">
                                <label for="nope-vis" >No</label>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group form-group-lg">
                        <label for="inputPassword" class="col-sm-2  col-form-label">Allow Comments</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input type="radio" id="yup-comment"  name="comment" value="0" checked>
                                <label for="yup-comment">Yes</label>
                            </div>
                            <div>
                                <input type="radio" id="nope-comment"  name="comment" value="1">
                                <label for="nope-comment">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group form-group-lg">
                        <label  class="col-sm-2  col-form-label">Allow Ads</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input type="radio" id="yup-add"  name="ads" value="0" checked>
                                <label for="yup-add">Yes</label>
                            </div>
                            <div>
                                <input type="radio" id="nope-add"  name="ads" value="1">
                                <label for="nope-add">No</label>
                            </div>
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
        elseif ($do=="Insert") {

            if(isset($_POST['Name'])&&isset($_POST['visible'])&&isset($_POST['ads']))
            {
                echo "<h1 class='text-center'>Insert Category</h1>";
                echo "<div class='container'>";
                $Name=$_POST['Name'];
                $describe=$_POST['Describe'];
                $order=$_POST['order'];
                $visible=$_POST['visible'];
                $comment=$_POST['comment'];
                $ads=$_POST['ads'];

                if(!empty($Name)&&$ads!=null&&$comment!=null&&$visible!=null)
                {
                   
                if(checkitem("Name","categories",$Name)>0)
                {
                   echo "<div class='alert alert-danger'>sorry this category exist before</div>";
                   redirect(2,"back");
                }else
                {
                    $stmt=$con->prepare("INSERT INTO 
                                categories(Name,Description,Ordering,Visibility,Allow_Comment,Allow_Ads) 
                                VALUES (?, ?, ?, ?,?,?)");
                    $stmt->execute(array($Name,$describe,$order,$visible,$comment,$ads));
                    echo "<div class='alert alert-success'>".$stmt->rowCount()."Record Inserted</div>";
                }
                        
                redirect(2,"back","categories.php");
                        
                    
                    
                    
                }
                else
                    {
                       echo "<div class='alert alert-danger'>". $msg."</div>";
                    }
            }
            else
            {	
                echo "<div class='alert alert-danger'>you can't browse this page directly</div>"."<br>";
                        
                redirect(2,"back");
            }
            
            echo "</div>";       
        }
        elseif($do=="Edit")
        {
            $catid=isset($_GET['catid'])&&is_numeric($_GET['catid'])? intval($_GET['catid']) : 0;
            $stmt= $con->prepare("SELECT * FROM categories Where ID=?");
            $stmt->execute(array($catid));
            $row= $stmt->fetch();
            $count=$stmt->rowCount();
            if($count>0)
            {


            ?>
            <h1 class="text-center">Edit Category</h1>
            <div class="container">
            <form method="POST" action="categories.php?do=Update">
                    <div class="form-group row">
                        <label  class="col-sm-2 col-md-offset-6 col-form-label">Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text"  class="form-control" id="staticEmail"  autocomplete="off" name="Name" value=<?php echo $row['Name'] ?> required >
                            <input type="text" name="id"  hidden value=<?php echo $row['ID'] ?> >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label  class="col-sm-2 col-md-offset-6 col-form-label">Description</label>
                        <div class="col-sm-10 col-md-6">
                        <input type="text" class="form-control"  name="Describe" autocomplete="off" value=<?php if(!empty($row['Description']))echo $row['Description']?> >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-md-offset-6 col-form-label">Ordering</label>
                        <div class="col-sm-10 col-md-6">
                        <input type="text" class="form-control"  autocomplete="off" name="order" value=<?php if(!empty($row['Ordering']))echo $row['Ordering']?> >
                        </div>
                    </div>
                    <div class="form-group form-group-lg row">
                        <label for="inputPassword" class="col-sm-2  col-form-label">Visible</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input type="radio" id="yup-vis"  name="visible" value="0" <?php if($row['Visibility']==0)echo "checked" ?> >
                                <label for="yup-vis">Yes</label>
                            </div>
                            <div>
                                <input type="radio" id="nope-vis"  name="visible" value="1" <?php if($row['Visibility']==1)echo "checked" ?>>
                                <label for="nope-vis" >No</label>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group form-group-lg">
                        <label for="inputPassword" class="col-sm-2  col-form-label">Allow Comments</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input type="radio" id="yup-comment"  name="comment" value="0" <?php if($row['Allow_Comment']==0)echo "checked" ?>>
                                <label for="yup-comment">Yes</label>
                            </div>
                            <div>
                                <input type="radio" id="nope-comment"  name="comment" value="1" <?php if($row['Allow_Comment']==1)echo "checked" ?>>
                                <label for="nope-comment">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group form-group-lg">
                        <label  class="col-sm-2  col-form-label">Allow Ads</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input type="radio" id="yup-add"  name="ads" value="0" <?php if($row['Allow_Ads']==0)echo "checked" ?>>
                                <label for="yup-add">Yes</label>
                            </div>
                            <div>
                                <input type="radio" id="nope-add"  name="ads" value="1" <?php if($row['Allow_Ads']==1)echo "checked" ?>>
                                <label for="nope-add">No</label>
                            </div>
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
        elseif($do=="Update")
        {
            	  		
	  		if(isset($_POST['Name'])&&isset($_POST['id']))
	  		{
	  			echo "<h1 class='text-center'>Update Member</h1>";
                echo "<div class='container'>";
                $catid=$_POST['id'];
	  			$name=$_POST['Name'];
	  			$describe=$_POST['Describe'];
	  			$visible=$_POST['visible'];
	  			$allow_comm=$_POST['comment'];
                $allow_ads=$_POST['ads'];
                if(!empty($_POST['Name']))
                {
                    $stmt=$con->prepare("UPDATE categories SET  Name=? , Description=? , Visibility=? , Allow_Comment=?, Allow_Ads=? WHERE ID=?");
	  		    	$stmt->execute(array($name,$describe,$visible,$allow_comm,$allow_ads,$catid));
                    echo "<div class='alert alert-success'>".$stmt->rowCount()."Record Updated</div>";
                }
                else
                {
                    echo "<div class='alert alert-danger'>the Name can't be empty</div>";
                    redirect(2,"back");
                }
	  			
                redirect(2,"back","categories.php");

	  				
	  				
	  			
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
            echo "<h1 class='text-center'>Delete Category</h1>";
            $catid=isset($_GET['catid'])&&is_numeric($_GET['catid'])? intval($_GET['catid']) : 0;
            if(checkitem("ID","categories",$catid)==1)
            {
                $stmt=$con->prepare("DELETE FROM categories WHERE ID=?");
                $stmt->execute(array($catid));
                echo "<div class='alert alert-success'>".$stmt->rowCount()."Record Deleted</div>";
                redirect(2,"members.php","categories.php");	
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
        header("Location:index.php");

    }
    ob_end_flush();
?>