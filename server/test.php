<?php
include ('SCRIPTS/utilities/database_connection.inc');

$result = DBQuery("SELECT user_id FROM Users");




while($row = mysqli_fetch_row($result)){
	echo "\n" . $row[0] . "\n";
}

