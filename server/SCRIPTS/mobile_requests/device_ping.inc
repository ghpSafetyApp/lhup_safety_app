<?php

include_once '../utilities/database_connection.inc';
include_once '../utilities/utilities.inc';

function device_ping($attributes){

	$conn = DBConnect();
	
	//attributes
	//  0: id
	//  1: Mac Address
	
	$result = mysqli_query($conn, "SELECT device_id FROM Devices where device_mac = '" . $attributes[1] . "' And device_active = 2");
	file_put_contents("log.txt", "DB, MAC: " . $attributes[1] ."\n", FILE_APPEND);
	if($result === false){
		//Database Error
		echo 0;
		file_put_contents("log.txt", "0\n", FILE_APPEND);
		die;
	} else {
		
		if(mysqli_num_rows($result) > 0){
			//Device is confirmed
			
			file_put_contents("log.txt", "Success\n", FILE_APPEND);
				
			echo 1;
			die;
		} else {
			//Device not confirmed
			file_put_contents("log.txt", "2\n", FILE_APPEND);
			echo 2;
			die;
		}
		
	}
}