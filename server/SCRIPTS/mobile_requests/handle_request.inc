<?php

include_once "../utilities/Decrypt.php";
include_once 'device_register.inc';
include_once 'receive_message.inc';
include_once 'receive_call.inc';

function handle_message($request){
	
	
	
	$attributes = explode("|", $request);
	
	$stat = intval($attributes[0]);
	
	switch ($stat){
		//Register Request
		case 1:
			register_request($attributes);
			break;
		
			
		//Add Device	
		case 2:
			
			file_put_contents("log.txt", "$request \n", FILE_APPEND);
			device_request($attributes);
			break;
		
		//Unpair Device
		case 3:
		
			break;
		
		//Phone call	
		case 4:
			call_request($attributes);
			break;
		
		//Sent Message
		case 5:
			file_put_contents("log.txt", "In Case 5\n", FILE_APPEND);
			message_request($attributes);
			break;
		default:
			file_put_contents("log.txt", "Did not find the jigger\n", FILE_APPEND);
			echo 0;
	}
	
}

?>