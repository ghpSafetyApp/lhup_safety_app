<?php

function createAdmin($conn){



echo "\nCreating the Admin Account.\n";


$user_username = "admin";
$user_fname = "Admin";
$user_lname = "Admin";

$password = stripslashes(crypt('AdminPassword', '$2a$10$leskfiqamdhjthrjwsksdidfhrjrkdlsldlkfjjgird$'));


$stmnt = "Insert into Users values (null, '$user_username', '$user_fname', '$user_lname', 2, '$password')";

mysqli_query($conn, $stmnt);

$stmnt = "insert into Permissions values (null, 1, 1, 0, 0, 0, 0, 0, 0)";

mysqli_query($conn, $stmnt);

return true;

}
?>
