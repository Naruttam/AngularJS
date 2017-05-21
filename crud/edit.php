<?php
include_once 'dbconfig.php';

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)){
	    $_POST = json_decode(file_get_contents('php://input'), true);
	}

	$id = $_POST['id'];
	$edit_query = "SELECT id, first_name, last_name, email, sex, state, tags FROM customers where id= ".$id;
	$edit_set=mysql_query($edit_query);
	if(mysql_num_rows($edit_set)>0)
	{ 
		while($row=mysql_fetch_assoc($edit_set))
		{
			$editarray[] = $row;
		}
	}
	
	/*return $editarray;*/
	/*print_r($editarray); exit();*/
	echo json_encode($editarray);
?>