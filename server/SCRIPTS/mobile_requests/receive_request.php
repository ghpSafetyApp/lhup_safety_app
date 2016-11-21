<?php

require_once 'handle_request.inc';

file_put_contents("log.txt", "Here1\n");
if(isset($_POST["request_string"])){
	file_put_contents("log.txt", "Here2\n");
	handle_message($_POST["request_string"]);
} else {
	file_put_contents("log.txt", "Here3\n");
	echo "0";
}

?>