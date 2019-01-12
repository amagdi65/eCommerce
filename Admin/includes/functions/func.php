<?php
//this function to get title of pages
function getTitle()
{
	global $title;
	if(isset($title))
	{
		echo $title;
	}
	else
	{
		echo "Admin";
	}
}
//this function to redirect
function redirect($second=3,$urll=null,$ur=null)
{	
	if($urll==null&&$ur==null)
	{
		$urll="index.php";
	}
	else
	{
		if(isset($_SERVER['HTTP_REFERER'])&&$ur==null)
		{
			$urll=$_SERVER['HTTP_REFERER'];	
		}
		else if($ur!=null)
		{
			$urll=$ur;
		}
		else
		{
			$urll="index.php";
		}
		
	}
	echo "<div class='alert alert-info'>you will be redirect after ".$second." seconds</div>";
	header("refresh:$second;url=$urll");
	exit();
}
//this function to check for the record if exist

function checkitem($select,$from,$value)
{
	global $con;
	$stmt= $con->prepare("SELECT $select FROM $from WHERE $select=?");
	$stmt->execute(array($value));
	$count=$stmt->rowCount();
	return $count;
}
//this function to count items
function calcitems($column,$table,$condition="",$value="")
{
	global $con;
	if($condition=="" || $value=="")
	{
		$stmt=$con->prepare("SELECT COUNT($column) FROM $table");
		$stmt->execute();
	}else
	{
		$stmt=$con->prepare("SELECT COUNT($column) FROM $table WHERE $condition=?");
		$stmt->execute(array($value));
	}
	
	
	return $stmt->fetchcolumn();
}
//This function to get latest item or user
function Getlatest($select,$from,$order,$limit)
{
	global $con;
	$stmt=$con->prepare("SELECT $select FROM $from ORDER BY $order DESC LIMIT $limit");
	$stmt->execute();
	return $stmt->fetchAll();
}