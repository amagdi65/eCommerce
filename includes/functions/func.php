<?php

/*start front end function*/
//this function to get anything
function Getall($field,$fromtable,$where=null,$and=null,$orderby,$order="DESC")
{
	//$sql=($where==null)? '': $where;
	global $con;
	$all=$con->prepare("SELECT $field FROM $fromtable $where $and  ORDER BY $orderby $order");
	$all->execute();
	return $all->fetchAll();
}
//this function is to get categories
function GetCat()
{
	global $con;
	$cat=$con->prepare("SELECT * FROM categories ORDER BY ID ASC");
	$cat->execute();
	return $cat->fetchAll();
}
//this function is to get items
function GetItems($where,$value,$approve=null)
{

	global $con;
	if($approve == null)
	{
		$query="AND Approve=1";
	}
	else
	{
		$query=null;
	}
	$stmt=$con->prepare("SELECT * FROM items WHERE $where=? $query ORDER BY item_ID DESC");
	$stmt->execute(array($value));
	return $stmt->fetchAll();
}
//this function is to get comments
function getcomment($where,$value)
{
	global $con;
	$stmt=$con->prepare("SELECT * FROM comments WHERE $where=? ORDER BY c_id DESC");
	$stmt->execute(array($value));
	return $stmt->fetchAll();
}



/*start check userstatus function*/
function checkuserstatus($user)
{
	global $con;
	$stmt = $con->prepare("SELECT * from users WHERE username= ? AND RegStatus=0 ");
	$stmt->execute(array($user));
	$count=$stmt->rowCount();
	return $count;
}
/*end user statusfunction*/


/*this function check if item exist*/
function checkitem($select,$from,$value)
{
	global $con;
	$stmt= $con->prepare("SELECT $select FROM $from WHERE $select=?");
	$stmt->execute(array($value));
	$count=$stmt->rowCount();
	return $count;
}
/*end function check if item exist*/
/*end front end function*/









/*start back end function*/ 
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