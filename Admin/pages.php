<?php
session_start();
	  if(isset($_SESSION['Username']))
	  {
	  	$title="Members";
	  	include "ini.php";
	  	$do=isset($_GET['do'])? $_GET['do']:"Manage";
	  	if($do=="Manage") {	

        }
        elseif ($do =="Edit") {
	  		
        }
        elseif ($do =="Add") {
            
      
        }
        else if($do=="Update") {
	  		
	  	
        }	
        else if($do=="Insert") {
	  		
        } 
        elseif($do=="Delete") {
	  		
        }
        include "includes/templates/footer.php";
				
	  }else
	  {
	  	header("location : index.php");
	  	exit();
	  }