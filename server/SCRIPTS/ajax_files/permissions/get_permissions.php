<?php
require_once "../../utilities/database_connection.inc";

$rows = 25;
$current = 1;
$limit_l = ($current * $rows) - ($rows);
$limit_h = $limit_l + $rows;
$limit = "";

$conn = DBConnect();

if ($conn != false) {
	
	$json = array ();
	
	if (isset ( $_POST ["rowCount"] )) {
		$rows = removeslashes ( $_POST ["rowCount"] );
	}
	
	if (isset ( $_POST ["current"] )) {
		$current = removeslashes ( $_POST ["current"] );
		
		$limit_l = ($current * $rows) - ($rows);
		$limit_h = $rows;
	}
	
	if (isset ( $_POST ["searchPhrase"] )) {
		$searchPhrase = removeslashes ( $_POST ["searchPhrase"] );
	}
	
	if (isset ( $_POST ['sort'] ) && is_array ( $_POST ['sort'] )) {
		$order = "";
		foreach ( $_POST ['sort'] as $key => $value ) {
			$order .= " $key $value";
		}
		$order = " ORDER BY" . $order;
	}
	
	if ($rows == - 1) {
		$limit = "";
	} else {
		$limit = " LIMIT $limit_l,$limit_h ";
	}
	
	$query = "SELECT user_id, user_fname, user_lname, perm_users, perm_end_users, perm_calls, perm_messages, perm_devices, perm_audit, perm_id FROM Permissions LEFT JOIN Users USING(user_id) WHERE (CONCAT_WS(' ', user_fname, user_lname) LIKE('$searchPhrase%') OR user_lname LIKE('$searchPhrase%')) AND user_id != 1 $order $limit";
	
	$result = mysqli_query ( $conn, $query );
	
	$res_array = array ();
	
	while ( $this_row = mysqli_fetch_assoc ( $result ) ) {
		$res_array [] = $this_row;
	}
	
	$json = json_encode ( $res_array );
	
	$total_rows = mysqli_query ( $conn, "SELECT user_id FROM Permissions LEFT JOIN Users USING(user_id) WHERE (CONCAT_WS(' ', user_fname, user_lname) LIKE('$searchPhrase%') OR user_lname LIKE('$searchPhrase%')) AND user_id != 1 $order $limit" );
	
	$trows = mysqli_num_rows($total_rows);
	
	echo "{ \"current\": $current, \"rowCount\":$rows, \"rows\": " . $json . ", \"total\": $trows }";
	$season = json_decode ( $str, true );
}
die ();

?>