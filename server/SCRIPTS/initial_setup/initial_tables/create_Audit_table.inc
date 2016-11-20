<?php
/*
create_audit_table.inc
 
Created By: William Grove
 
11/3/2016
*/
 
 
function createAuditTable($conn){
 
    $statement =
 
    "create table Audit(
 
aud_id Integer not null auto_increment,
 
primary key (aud_id),          


user_id Integer not null,


aud_code Integer not null,            
            
aud_data varchar(40) not null,


aud_date datetime not null,


foreign key (user_id) references Users(user_id)  on delete cascade
 
) ENGINE=InnoDB";
    
    if(!$result = mysqli_query($conn, $statement)){
        
        echo "\nThere was an error creating the Audit Table";
        echo "Please contact the System Administrator";
        return false;
    } else {
        mysqli_free_result($result);
        echo "\nUsers Table was created successfully.";
        return true;
    }
}
 
?>
