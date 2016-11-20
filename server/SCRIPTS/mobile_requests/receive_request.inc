<?php
if(isset($_POST["request_string"])){
	handle_request($_POST["request_string"]);
} else {
	echo "0";
}

?>