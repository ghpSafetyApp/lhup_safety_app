<?php

function confirmEndUser($hash, $conn){

	$hash = urldecode($hash);
	
	$result = mysqli_query($conn, "SELECT end_user_id, end_user_status FROM EndUsers where end_user_hash = '$hash'");

	if($result === false) {
		return "User Not Found";
	}

	$row = mysqli_fetch_row($result);

	if(intval($row[1]) === 3){
		return "Sorry, you have been banned.";
	}

	if(intval($row[0]) === 2){
		return "This account has already been confirmed.";
	}

	$result = mysqli_query($conn, "Update EndUsers SET end_user_status = 2 WHERE end_user_id = " . $row[0]);

	if($result === false){
		return "Error Confirming your account";
	} else {
		return "Account Confirmed.";
	}


}