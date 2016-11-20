<?php 

function password_encrypt($password){
	
	return crypt($password, '$2a$10$leskfiqamdhjthrjwsksdidfhrjrkdlsldlkfjjgird$');
}

function device_hash($string){
	return crypt($string, '$2a$10$zlsodsgmsmmwmeigovosddgamsjkfkgjlmdssadthas$');
}

function user_hash($string){
	return crypt($string, '$2a$10$zlsodsgmsmmwmdkfirjwmsndhrimanserfniswqaldo$');
	
}

function get_post_values($string){
	return explode("|", removeslashes($string));
}

?>