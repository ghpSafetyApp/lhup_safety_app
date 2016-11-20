<?php

session_start();

require_once '../accessors/access_audit.inc';
require_once '../utilities/database_connection.inc';
require_once '../utilities/get_permissions.inc';

if(isset($_POST["auditupdaterequest"])){

	$conn = DBConnect();

	if($conn == false){
		echo "Unable to Connect to Database.";
		return;
	}

	if(getPermissions($conn) == false){
		echo "Unable to retrieve permissions.";
		DBClose($conn);
		return;
	}
	
	$opcode = 0;

	if(isset($_POST["opcode"])){
		$opcode = intval(removeslashes($_POST["opcode"]));

		if($opcode == 0){
			echo "Malformed Operation.";
			DBClose($conn);
			return;
		}
	} else {
		echo "Opcode not set.";
		DBClose($conn);
		return;
	}

	
	//Delete
	if($opcode == 2){
		
		$aud_id = 0;
		
		if(isset($_POST["aud_id"])){
			$aud_id = intval(removeslashes($_POST["aud_id"]));
		
			if($aud_id == 0){
				echo "Malformed Operation.";
				DBClose($conn);
				return;
			}
		} else {
			echo "Audit ID not set.";
			DBClose($conn);
			return;
		}
		
		
		$result = deleteAuditEntry($aud_id, $conn);
		
		if($result === true){
			echo "success";
		} else {
			echo $result;
		}
		
		DBClose($conn);
		return;
		
	}
	
	
	
	
	
} else {
	echo "Invalid request";
	return;
}
?>