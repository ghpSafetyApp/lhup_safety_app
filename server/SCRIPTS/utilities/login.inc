<?php
/*
 * login.inc
 *
 * Created By: William Grove
 *
 * Allows a user to log into the web portal. For
 * public safety users only.
 *
 * Created On: 11/2/2016
 *
 */

// requires "database_connection.inc" for DB connection
// requires "utilities" for password hashing
require_once "database_connection.inc";
require_once "utilities.inc";

$error = '';
$username = '';

if (isset ( $_POST ['submit'] )) {
	if (empty ( $_POST ['username'] ) || empty ( $_POST ['password'] )) {
		$error = "Username or Password is empty.";
	} else {
		
		// Sanitize the username
		$username = removeslashes( $_POST ['username'] );
		
		// Sanitize the password, and encrypt it
		$password = password_encrypt( $_POST ['password'] );
		
		$conn = DBConnect();
		
		$result = mysqli_query($conn, "SELECT user_id, user_username, user_fname, user_isactive FROM Users WHERE user_username = '$username' AND user_password = '$password'" );	
		
		if ($result !== false) {
			
			session_start ();
			
			$number_of_rows = 0;
			
			if ($result) {
				
				while ( $row = mysqli_fetch_row ( $result ) ) {
					$number_of_rows = $number_of_rows + 1;
					$_SESSION ["userid"] = $row [0];
					$_SESSION ["username"] = $row [1];
					$_SESSION ["name"] = $row [2];
					$_SESSION ["status"] = $row [3];
				}
			}
			
			mysqli_free_result ( $result );
			
			if ($number_of_rows > 0) {
				
				if ($_SESSION ["status"] != 6) {
					
					$array = array ();
					
					$result = mysqli_query($conn, "Select perm_admin, perm_users, perm_end_users, perm_calls, perm_messages, perm_devices, perm_audit FROM Permissions WHERE user_id =" . $_SESSION ["userid"] );
					
					while ( $row = mysqli_fetch_row ( $result ) ) {
						for($r = 0; $r < count ( $row ); $r ++) {
							$array [] = intval ( $row [$r] );
						}
					}
					
					mysqli_free_result ( $result );
					DBClose($conn);
					$_SESSION["permissions"] = $array;
					
					header ( "location: index.php" );
				} else {
					$error = 'Access Denied';
				}
			} else {
				DBClose($conn);
				$error = 'Username or Password Incorrect';
				
			}
		} else {
			DBClose($conn);
			$error = 'Could Not Connect To Database';
		}
	}
}
?>