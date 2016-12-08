<?php

include_once "../utilities/Decrypt.php";
include_once 'device_register.inc';
include_once 'receive_message.inc';
include_once 'receive_call.inc';
include_once 'device_ping.inc';

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
		
		//Unpair Device, not implemented yet
		case 3:
		
			break;
		
		//Phone call	
		case 4:
			call_request($attributes);
			break;
		
		//Sent Message
		case 5:
			message_request($attributes);
			break;
		//Device Ping
		case 6:
			device_ping($attributes);
			file_put_contents("log.txt", "Did not find the jigger\n", FILE_APPEND);
				
			break;
		default:
			//file_put_contents("log.txt", "Did not find the jigger\n", FILE_APPEND);
			echo 0;
	}
	
}

?>