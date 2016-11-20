<?php
/*
 * update_factory.inc
 * 
 * Created By: William Grove
 * 
 * Date: 6/18/2016
 * 
 * Takes a table name, an array of
 * 
 * SET [col1 = param] strings, and a where clause;
 * 
 */

/**
 * 
 * Test permissions before calling this function
 * UPDATE '$tablename' SET 'field = value' WHERE 'clause'
 * 
 * Code 0: Both Strings
 * 
 * Code 1: String sets, Array of Where
 * 
 * Code 2: Array of sets, String of Where
 * 
 * Code 3: Both Arrays
 * 
 * @param unknown $table_name
 * @param unknown $set_array
 * @param unknown $where_clause
 * @param unknown $op_mode
 * @param unknown $conn
 */
function update($table_name, $set_clause, $where_clause, $op_code, $conn){
	file_put_contents("log.txt", "Inside update factory.\n");
	
	$query = "UPDATE $table_name SET ";
	
	//string of where string of set
	if($op_code == 0){
		$query = $query . $set_clause . " WHERE " . $where_clause; 
	}
	
	//String of sets ARRAY of where
	if($op_code == 1){
		
		$query = $query . $set_clause . " WHERE ";
		
		for($index = 0; $index < count($where_clause); $index++){
			$query = $query . $where_clause[$index];
		}
		
	}
	
	//Array of sets string of where
	if($op_code == 2){
		
		file_put_contents("log.txt", "Inside update factory. Opcode 2\n");
		
	$begin_where = count($set_clause) - 1;
	
	for($index = 0; $index < count($set_clause); $index++){
		$query = $query . $set_clause[$index];
		
		if($index != $begin_where){
			$query = $query . ", ";
		}
		
	}
	
	$query = $query . " WHERE " . $where_clause;
	
	
}
//Array of sets, array of where, will work is used.
if($op_code == 3 ){
	
	$begin_where = count($set_clause) - 1;
	
	for($index = 0; $index < count($set_clause); $index++){
		$query = $query . $set_clause[$index];
	
		if($index != $begin_where){
			$query = $query . ", ";
		}
	
	}
	
	$query = $query . " WHERE ";
	
	file_put_contents("log.txt", "$query \n", FILE_APPEND);
	
	for($index = 0; $index < count($where_clause); $index++){
		$query = $query . $where_clause[$index];
	}
	
}

file_put_contents("log.txt", "Inside update factory. Before Query.\n");
file_put_contents("log.txt", "Query: " . $query);
$result = mysqli_query($conn, $query);
	
	if($result == false){
		return "Update failed.";
	} else {
		return true;
	}

}




?>