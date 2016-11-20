<?php
/*
create_users_table.inc
 
Created By: William Grove
 
10/3/2016
*/
 
 
function createUsersTable($conn){
 
    $statement =
 
    "create table Users(
 
user_id Integer not null auto_increment,
 
primary key (user_id),          


user_username varchar(15) not null,


user_fname varchar(35) not null,            
            
user_lname varchar(35) not null,


user_isactive Integer not null,
 
user_password varchar(80) not null
 
) ENGINE=InnoDB";
    
    if(!$result = mysqli_query($conn, $statement)){
        
        echo "\nThere was an error creating the Users Table";
        echo "Please contact the System Administrator";
        return false;
    } else {
        mysqli_free_result($result);
        echo "\nUsers Table was created successfully.";
        return true;
    }
}
 
?>