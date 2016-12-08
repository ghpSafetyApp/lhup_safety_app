<?php

function createAdmin($conn){



echo "\nCreating the Admin Account.\n";


$user_username = "admin";
$user_fname = "Admin";
$user_lname = "Admin";

$password = stripslashes(crypt('AdminPassword', '$2a$10$leskfiqamdhjthrjwsksdidfhrjrkdlsldlkfjjgird$'));


$stmnt = "Insert into Users values (1, '$user_username', '$user_fname', '$user_lname', 2, '$password')";

mysqli_query($conn, $stmnt);

$stmnt = "insert into Permissions values (null, 1, 1, 0, 0, 0, 0, 0, 0)";

mysqli_query($conn, $stmnt);

$stmnt = "Insert into EndUsers values (-10, 'unknown_user', 'Unknown', 'User', 2, 'Drink your Ovaltine','42 is the answer to everything')";

mysqli_query($conn, $stmnt);

return true;

}
?>
