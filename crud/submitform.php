<?php
include_once 'dbconfig.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)){
    $_POST = json_decode(file_get_contents('php://input'), true);
    
    foreach ($_POST as $key => $value) {
    	$finalData = $value['formData'][0];
    }
    
}
if(isset($_POST['firstname']) && $_POST['firstname'] == 'error')
{
	var_dump(http_response_code(400));
}
else
{
	$id = $finalData['id'];
	
	if($id){

		if($finalData['tags']){
			foreach ($finalData['tags'] as $key => $value) {
				$tagsArray[] = $value['text']; 
			}
			$tags = implode(" | ", $tagsArray);
		}

		$update_array = array( array(
		'first_name' 	=> $finalData['firstname'],
		'last_name'		=> $finalData['lastname'],
		'email'			=> $finalData['email'],
		'sex'			=> $finalData['sex'],
		'state'			=> $finalData['state']['state'],
		'tags'			=> $tags
		));

		if(is_array($update_array)){
		    foreach($update_array as $key => $value){
			    $fname 	=  	$value['first_name'];
			    $lname 	= 	$value['last_name'] ;
			    $email 	=  	$value['email'] ;
			    $sex 	= 	$value['sex'] ;
			    $state 	= 	$value['state'] ;
			    $tags  	= 	$value['tags'];

			    $sql = "UPDATE customers  SET  first_name = '{$fname}' , last_name = '{$lname}', email = '{$email}',
			    sex = '{$sex}', state = '{$state}', tags = '{$tags}' WHERE id = ".$id; 
				echo $sql;
			    /*values ('$fname', '$lname', '$email', '$sex', '$state'); */
			    mysql_query($sql) or exit(mysql_error()); 
		    }
		}
	}
	else{

		if($finalData['tags']){
			foreach ($finalData['tags'] as $key => $value) {
				$tagsArray[] = $value['text']; 
			}
			$tags = implode(" | ", $tagsArray);
		}

		$insert_array = array( array(
			'first_name' 	=> $finalData['firstname'],
			'last_name'		=> $finalData['lastname'],
			'email'			=> $finalData['email'],
			'sex'			=> $finalData['sex'],
			'state'			=> $finalData['state']['state'],
			'tags'			=> $tags
		));
		/*print_r($insert_array); exit();*/
		if(is_array($insert_array)){
		    foreach($insert_array as $key => $value){
		    $fname =  $value['first_name'];
		    $lname = $value['last_name'] ;
		    $email =  $value['email'] ;
		    $sex = $value['sex'] ;
		    $state = $value['state'] ;
		    $tags  = $value['tags'];

		    $sql = "INSERT INTO customers ( first_name, last_name, email, sex, state, tags) 
		    values ('$fname', '$lname', '$email', '$sex', '$state' , '$tags')";
		    mysql_query($sql) or exit(mysql_error()); 
		    }
		}
	}

	

	/* $q = $sql->prepare("INSERT INTO `customers` 
                     SET  `first_name` = ?, `last_name` = ?,  email = ?,  sex = ?, state = ? ");

	 foreach($insert_array as $value){
	   $q ->execute( array( $value['first_name'], $value['last_name'], $value['email'], $value['sex'],  $value['state'] ));
	 }*/

	//echo json_encode();
}
?>