<?php

include_once '../utilities/database_connection.inc';
include_once '../utilities/utilities.inc';
/*
 * Unlike other functions that handles data,
 * this function also requires another POST
 * data to recieve the image bytes.
 */
function message_request($attributes){

	$conn = DBConnect();
	
	//0: req_id, 1: maccaddress, 2: text, 3: latitude
	//4: longitude, 5: image
	file_put_contents("log.txt", "In rec_message 5\n", FILE_APPEND);
	
	
	$mac = $attributes[1];
	$text = $attributes[2];
	$lat = $attributes[3];
	$lon = $attributes[4];
	$image = $attributes[5];
	$has_image = false;
	if(strcmp($image, "n") != 0){
		$image = base64_decode($attributes[5]);
		$has_image = true;
	}
	
	$imagename = "";
		
	$result = mysqli_query($conn, "SELECT device_id FROM Devices WHERE device_mac = '$mac' AND device_active = 2");
	
	if($result === false){
		echo 16;
	} else {
		
		$row = mysqli_fetch_row($result);
		$device_id = $row[0];
		
		//Insert the message
		$result = mysqli_query($conn, "INSERT INTO Messages VALUES(null, '$text', '$imagename', '$device_id', NOW(), '$lat','$lon','')");
		
		if($result === false){
			echo 17;
			die;
		} else {
							
			$result = mysqli_query($conn, "SELECT msg_id From Messages where device_id = $device_id Order By msg_id DESC LIMIT 1");				
			
			$row = mysqli_fetch_row($result);
			
			$imagename = "msg" . $row[0] . "img.png";
			
			//If there was an image
			if($has_image == true){				
				
			$file = fopen('../images/'.$imagename, 'wb');
			$pass = fwrite($file, $image);
			fclose($file);
			
			//Kill if the image failed to upload
			if($pass === false){
				echo 15;
				die;
			}
			
			$result = mysqli_query($conn, "UPDATE Messages SET msg_imagepath = '$imagename' WHERE msg_id = " . $row[0]);
			
			if($result === false){
				echo 3;
			}
			
			}
			//success				
			
			echo 1;
			die;
			
			
			
		}
		
	}
	
	



}
?>