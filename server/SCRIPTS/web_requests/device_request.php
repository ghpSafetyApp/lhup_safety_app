<?php

session_start();

require_once '../accessors/access_devices.inc';
require_once '../utilities/get_permissions.inc';
require_once '../utilities/database_connection.inc';
require_once '../update_factory/update_factory.inc';

if(isset($_POST["deviceupdaterequest"])){

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
		
		$device_id = 0;
		
		if(isset($_POST["device_id"])){
			$device_id = intval(removeslashes($_POST["device_id"]));
		
			if($device_id == 0){
				echo "Malformed Operation.";
				DBClose($conn);
				return;
			}
		} else {
			echo "Call ID not set.";
			DBClose($conn);
			return;
		}
		
		
		$result = deleteDevice($device_id, $conn);
		
		if($result === true){
			echo "success";
		} else {
			echo $result;
		}
		
		DBClose($conn);
		return;
		
	}
	
	
	
	//Update
	if($opcode == 1){
		
		if(($_SESSION["permissions"][0] == 1) == false){
			echo "You do not have permission to update Capstones.";
		}
		
		$device_id = 0;
		
		$device_active = 0;
		
		$where = "device_id = ";
		$sets = array();
		
		if(isset($_POST["device_id"])){
			$device_id = intval(removeslashes($_POST["device_id"]));
		
			if($device_id == 0){
				echo "Malformed Operation.";
				DBClose($conn);
				return;
			}
			
			$where = $where . $device_id;
			
		} else {
			echo "Call ID not set.";
			DBClose($conn);
			return;
		}
		
		
		if(isset($_POST["device_active"])){
			$device_active = intval(removeslashes($_POST["device_active"]));
			
			if($device_active == 0){
				echo "Malformed Operation.";
				DBClose($conn);
				return;
			}
			
			$sets[] = "device_active = $device_active";
			
		} 
		
		
		
		if(count($sets) < 1){
			echo "Nothing to update";
			DBClose($conn);
			return;
		}
		
		$result = update("Devices", $sets, $where, 2, $conn);
		
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