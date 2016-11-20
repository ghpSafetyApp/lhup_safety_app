<?php
/*
create_users_table.inc
 
Created By: William Grove
 
10/3/2016
*/
 
 
function createEndUsersTable($conn){
 
    $statement =
 
    "create table EndUsers(
 
end_user_id Integer not null auto_increment,
 
primary key (end_user_id),          


end_user_username varchar(15) not null,


end_user_fname varchar(35) not null,            
            
end_user_lname varchar(35) not null,


end_user_status Integer not null,


end_user_hash varchar(80) not null,
 
end_user_password varchar(80) not null
 
) ENGINE=InnoDB";
    
    if(!$result = mysqli_query($conn, $statement)){
        
        echo "\nThere was an error creating the EndUsers Table\n";
        echo "Please contact the System Administrator";
        return false;
    } else {
        mysqli_free_result($result);
        echo "\nEndUsers Table was created successfully.";
        return true;
    }
}
 
?>
