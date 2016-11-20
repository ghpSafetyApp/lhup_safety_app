<?php
/*
create_users_table.inc
 
Created By: Nathan Bubb
 
11/6/2016
*/
 
 
function createCallsTable($conn){
 
    $statement =
 
    "create table Calls(
 
call_id Integer not null auto_increment,
 
primary key (call_id),          


device_id Integer not null,


call_type integer not null,


call_date datetime not null,            
            
call_gps_lat varchar(15),


call_gps_lon varchar(15),
 
call_comments varchar(500),


foreign key (device_id) references Devices(device_id)  on delete cascade


 
) ENGINE=InnoDB";
    
    if(!$result = mysqli_query($conn, $statement)){
        
        echo "\nThere was an error creating the Calls Table";
        echo "Please contact the System Administrator";
        return false;
    } else {
        mysqli_free_result($result);
        echo "\nCalls Table was created successfully.";
        return true;
    }
}
 
?>
