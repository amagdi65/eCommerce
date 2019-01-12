<?php 
      session_start();
	  $title="AMNCommerce";
      include "ini.php";
?>
    
    <div class="container">
        <h1 class="text-center"> <?php echo $_GET['pagename'];?> </h1>
        <div class="row">
        <?php
            $all=Getall("*","items","WHERE Cat_Id={$_GET['pageid']}","AND Approve = 1","item_ID");
            foreach ($all as $value)
            {
                echo "<div class='col-sm-6 col-md-3'>";
                    echo '<div class="card card-item">';
                        echo '<img class="card-img-top" src="layout\images\avatar2.png">';
                        echo '<span class="price">$'.$value['Price'].'</span>';
                        echo '<div class="card-body">';
                            echo '<h5 class="card-title"><a href=items.php?itemid='.$value['item_ID'].'>'.$value['Name'].'</a></h5>';
                            echo '<p class="card-text">'.$value['Description'].'</p>';    
                            
                        echo '</div>';
                        echo '<p class="card-text date">'.$value['Add_Date'].'</p>';
                    echo '</div>';
                echo "</div>";
            }
        ?>
        </div>
    </div>

 <?php include "includes/templates/footer.php"; ?>