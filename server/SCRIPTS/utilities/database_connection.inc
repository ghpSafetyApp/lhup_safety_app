<?php
/***************************
* db_connect.inc
*
* Created By: William Grove
*
* Creates a connection between the
* Database and PHP processor.
*
****************************/
function DBConnect() {
						//loopback   //db_user         //db_password   //db_name
$conn = mysqli_connect('127.0.0.1', 'butler', 'Williamgrove1', 'safehaven');
  return $conn;

}

function DBClose( $conn ) {

        $result = mysqli_close( $conn );
        return $result;
}

function DBQuery($query){
	
	$conn = DBConnect();
	
	if(mysqli_connect_errno() == 0){

	$result = mysqli_query($conn, mysqli_real_escape_string($conn, $query));
	
	DBClose($conn);
	
	return $result;
	
	} else {
		return "0";
	}
	
}

function removeslashes($string)
{
	$string=implode("",explode("\\",$string));
	return stripslashes(trim($string));
}

?>