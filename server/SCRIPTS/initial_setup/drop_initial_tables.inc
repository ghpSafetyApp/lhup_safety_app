<?php
/*
 *  drop_initial_tables.inc
 * 
 *  Created By: William Grove
 *  
 *  Date: 6/17/2016
 * 
 *  Used to drop tables on initial table
 *  creation failure. 
 *  
 *  !!!!!  WARNING  !!!!!
 *  
 *  DO NOT RUN THIS SCRIPT. THIS
 *  SCRIPT IS MEANT FOR THE INITIAL
 *  TABLE CREATION SCRIPT ONLY.
 *  
 *  
 */

/*
	String of letters appended to end of function
	name, helps prevent unintentional calling.
*/
function dropInitialTables_asldkfffignrmsdmsicigfjkdo
($conn){
	
	if(mysqli_query($conn, "DROP TABLE Calls")== false){
		echo "\nFailed to drop Calls\n";
	}
	
	if(mysqli_query($conn, "DROP TABLE Messages")== false){
		echo "\nFailed to drop Messages\n";
	}
	
	if(mysqli_query($conn, "DROP TABLE Devices") == false){
		echo "\nFailed to drop Device\n";
	}
	
	if(mysqli_query($conn, "DROP TABLE EndUsers")== false){
		echo "\nFailed to drop EndUser\n";
	}
	
	if(mysqli_query($conn, "DROP TABLE Permissions")== false){
		echo "\nFailed to drop Permissions\n";
	}
	
	if(mysqli_query($conn, "DROP TABLE Audit")== false){
		echo "\nFailed to drop Audit\n";
	}
	
	if(mysqli_query($conn, "DROP TABLE Users")== false){
		echo "\nFailed to drop Users\n";
	}
	
	
	
	
	return;
}
	

?>