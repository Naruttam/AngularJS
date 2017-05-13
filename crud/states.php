<?php
include_once 'dbconfig.php';

	/*if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)){
	    $_POST = json_decode(file_get_contents('php://input'), true);
	}

	$state = $_POST['state'];
	$cities_query = "SELECT city_name FROM statelist where state = '".$state."'";
	
	$city_set=mysql_query($cities_query);
	if(mysql_num_rows($city_set)>0)
	{ 
		while($row=mysql_fetch_assoc($city_set))
		{
			$cityarray[] = $row;
		}
	}
	/*return $editarray;
	//print_r($editarray); exit();
	echo json_encode($cityarray);*/
	
	$state_query = "SELECT id , name FROM `geo_locations` WHERE location_type = 'STATE' "
	$state_list  =  mysql_query($state_query);
	if(mysql_num_rows($state_query)>0)
	{ 
		while($row = mysql_fetch_assoc($state_query))
		{
			$state_list_array[] = $row;
		}
	}

	return $state_list_array;
	print_r($state_list_array); exit();
	echo json_encode($state_list_array);
?>