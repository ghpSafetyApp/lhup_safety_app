<?php



include_once '../utilities/database_connection.inc';
include_once '../utilities/utilities.inc';
/*
 * Unlike other functions that handles data,
 * this function also requires another POST
 * data to recieve the image bytes.
 */
function message_request($attributes){

	//0: req_id, 1: maccaddress, 2: text, 3: latitude
	//4: longitude
	
	$mac = $attributes[1];
	$text = $attributes[2];
	$lat = $attributes[3];
	$lon = $attributes[4];
	$imagename = "";
	
	$result = DBQuery("SELECT device_id FROM Devices WHERE device_mac = '$mac' AND device_active = 2");
	
	if($result === false){
		echo 16;
	} else {
		
		$row = mysqli_fetch_assoc($result);
		$device_id = $row[0];
		
		
		$file = "";
		$binary = "1";
		if(isset($_POST["image"])){
			
			// Get image string posted from Android App
			$base=$_POST['image'];
			// Decode Image
			$binary=base64_decode($base);
			//header('Content-Type: bitmap; charset=utf-8');
			// Images will be saved under 'www/imgupload/uplodedimages' folder
			
			// Create File
		}
		
		//Insert the message
		$result = DBQuery("INSERT INTO Messages VALUES(null, '$text', '$imagename', '$device_id', NOW(), '$lat','$lon','')");
		
		if($result === false){
			echo 17;
			die;
		} else {
			
			$result = mysqli_query($conn, "SELECT msg_id From Messages where device_id = $device_id Order By msg_id DESC LIMIT 1");
			
			$row = mysqli_fetch_row($result);
			
			$imagename = "msg" . $row[0] . "img";
			
			//If there was an image
			if($binary !== "1"){
			$file = fopen('../message_images/'.$imagename, 'wb');
			$pass = fwrite($file, $binary);
			fclose($file);
			
			//Kill if the image failed to upload
			if($pass === false){
				echo 15;
				die;
			}
			
			//Success
			echo 1;
			die;
			
			}
			
		}
		
	}
	
	



}
?>