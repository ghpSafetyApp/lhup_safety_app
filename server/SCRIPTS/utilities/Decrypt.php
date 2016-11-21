<?php

function DecryptString($cypher){

	/*
$output = array();

exec("java -jar Decrypt.jar '$cypher'", $output);

file_put_contents("log.txt", $output[0] . "\n", FILE_APPEND);

return $output[0];
*/
	
	return base64_decode(str_pad(strtr($cypher, '-_', '+/'), strlen($cypher) % 4, '=', STR_PAD_RIGHT));
}

?>