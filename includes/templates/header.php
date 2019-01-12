<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php  getTitle() ?></title>
        <link rel="stylesheet" href="layout/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="layout/css/all.css"/>
        <link rel="stylesheet"  href="layout/css/front.css">
	</head>
	<body>	
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
		<a class="navbar-brand" href="index.php"><?php echo lang("HOME_ADMIN");?></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
			<ul class="navbar-nav ">
				<?php
					$all=Getall("*","categories","","","ID","ASC");
					foreach($all as $cat)
					{
						echo '<li ><a class="nav-link" href="categories.php?pageid='.$cat['ID'].'&pagename='.$cat["Name"].'">'.$cat['Name'].'</a></li>';
						
					}
				?>
						<div class="upper-bar">
			<div class="container">
				<?php if(isset($_SESSION['name'])){?>
				<div class="btn-group my-info">
				<img class=" rounded-circle" src="layout\images\avatar2.png">
					<span class="btn dropdown-toggle" data-toggle="dropdown">
						<?php echo $_SESSION['name']?>
					</span>
					<div class="dropdown-menu">
						<a href='profile.php' class="dropdown-item">My Profile</a>
						<a href='newad.php' class="dropdown-item"> New Item</a>
						<a href='logout.php' class="dropdown-item">  Logout</a>
				</div>
				</div>
					
					<?php

					}else
					{
						
					
					?>
				<a href="login.php">
					<span class="float-right">LogIn/SignUp</span>
					<div class="clearfix"></div>
				</a>
				
				<?php }?>
			</ul>
			
		</div>
		</div>  
		</nav>