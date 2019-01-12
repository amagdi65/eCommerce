<?php
session_start();
	  if(isset($_SESSION['Username']))
	  {
	  	$title="Dashboard";
		include "ini.php";
		$limit=3;
		  
		  $row=Getlatest("*","users","userId",$limit);
		  $row2=Getlatest("*","items","item_ID",$limit);
?>
	<section class="homeStats">
		<h1 class="text-center">Dashboard</h1>
		<div class="container">
			<div class="row">
				<div class="col-md stat st-members">
					<p class="text-center">Total Members</p>
					<span class="text-center"><a href="members.php"><?php echo calcitems("userId","users")?></a></span>
				</div>
				<div class="col-md stat st-pendingmembers">
					<p class="text-center">Pending Members</p>
					<span class="text-center"><a href="members.php?do=Manage&page=pending"><?php echo calcitems("userId","users","RegStatus","0")?></a></span>
				</div>
				<div class="col-md stat st-totalitems">
					<p class="text-center">Total Items</p>
					<span class="text-center"><a href="items.php"><?php echo calcitems("item_ID","items")?></a></span>
				</div>
				<div class="col-md stat st-totalcomments">
					<p class="text-center">Total Comments</p>
					<span class="text-center"><a href="comments.php"><?php echo calcitems("c_id","comments")?></a></span>
				</div>
			</div>
		</div>
	</section>
	<section class="latest">
		<div class=container>
			<div class="row">
				<div class="col-md">
					<div class="card">
						<h5><i class="fas fa-users"></i> Latest Registerd User</h5>
						<div class="card-body">
							<p class="card-text">
								<?php 
									foreach($row as $value)
									{
										echo $value['username']."<br>";
									}
								?>
							</p>
						</div>
					</div>
				</div>
				<div class="col-md">
					<div class="card">
						<h5><i class="fas fa-tags"></i> Latest Items</h5>
						<div class="card-body">
							<p class="card-text">
									<?php 
										foreach($row2 as $value)
										{
											echo $value['Name']."<br>";
										}
									?>
							</p>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</section>
	
	  <?php
	 	include "includes/templates/footer.php"; }
	  else
	  {
	  	header("location : index.php");
	  	exit();
	  }

?>