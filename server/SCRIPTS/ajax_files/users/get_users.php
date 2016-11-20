<?php
require_once "../../utilities/database_connection.inc";


$rows = 25;
$current = 1;
$limit_l = ($current * $rows) - ($rows);
$limit_h = $limit_l + $rows;
$limit = "";
$order = "";
$prefix = "";

$conn = DBConnect();

if ($conn != false) {

	$json = array();
	$searchPhrase = "";

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

	if ($rows == -1) {
		$limit = "";
	} else {
		$limit = " LIMIT $limit_l,$limit_h ";
	}

	$query = "SELECT user_fname, user_lname, user_username, user_isactive, user_id FROM Users WHERE user_fname LIKE('$searchPhrase%') OR user_lname LIKE('$searchPhrase%') OR CONCAT_WS(' ', end_user_fname, end_user_lname) LIKE('$searchPhrase%') OR user_username LIKE('$searchPhrase%') $order $limit";

	$result = mysqli_query ( $conn, $query );

	$res_array = array();

	while ( $this_row = mysqli_fetch_assoc ( $result ) ) {
		$res_array [] = $this_row;
	}

	$json = json_encode ( $res_array );

	$query = "SELECT user_id FROM Users WHERE user_fname LIKE('$searchPhrase%') OR user_lname LIKE('$searchPhrase%') OR CONCAT_WS(' ', user_fname, user_lname) LIKE('$searchPhrase%') OR user_username LIKE('$searchPhrase%')";
	
	$result = mysqli_query ( $conn, $query );

	$trows = mysqli_num_rows($result);


	echo "{ \"current\": $current, \"rowCount\":$rows, \"rows\": " . $json . ", \"total\": $trows }";
	
}
die ();

?>