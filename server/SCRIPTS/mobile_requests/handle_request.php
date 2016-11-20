<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/SCRIPTS/utilities/Decrypt.php";

function handle_message($request){
	
	$attributes = explode("|", DecryptString($request));
	
	$stat = intval($attributes[0]);
	
	switch ($stat){
		//Register Request
		case 1:
			register_request($attributes);
			break;
		
			
		//Add Device	
		case 2:
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
			message_request($attributes);
			break;
		default:
			echo 0;
	}
	
}

?>