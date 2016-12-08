<?php
/*
create_devices_table.inc
 
Created By: William Grove, Nathan Bubb
 
11/4/2016
*/
 
 
function createDevicesTable($conn){
 
    $statement =
 
    "create table Devices(
 
device_id Integer not null auto_increment,
 
primary key (device_id),          

end_user_id integer not null,

device_mac varchar(80) not null,

device_phone_number varchar(15),

device_hash varchar(80) not null,
 
device_active integer not null,

device_register_date datetime,


unique(device_mac)
 
) ENGINE=InnoDB";
    
    if(!$result = mysqli_query($conn, $statement)){
        
        echo "\nThere was an error creating the DevicesTable";
        echo "Please contact the System Administrator";
        return false;
    } else {
        mysqli_free_result($result);
        echo "\nDevices Table was created successfully.";
        return true;
    }
}
 
?>
