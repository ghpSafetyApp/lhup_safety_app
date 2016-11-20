<?php

require '../utilities/database_connection.inc';
require 'create_initial_table_set.inc';
require 'initial_admin_account_creation.php';

$conn = DBConnect();

if(mysqli_connect_errno() == 0){
	
	if(createInitialTableSet($conn)){
		if(createAdmin($conn)){
			echo "\nSuccess";
		} else {
			echo "\nFailed to create admin.";
		}
	} else {
		echo "\nProgram failed to create the database.";
	}
	
	
	
	
	DBClose($conn);
	
}

?>

