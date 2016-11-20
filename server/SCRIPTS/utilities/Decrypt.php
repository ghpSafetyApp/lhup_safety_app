<?php

function DecryptString($cypher){

$output = "";

exec("java -jar Decrypt.jar $string", $cypher);

return $plain_text[0];

}

?>