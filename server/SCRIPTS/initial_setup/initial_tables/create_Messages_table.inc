<?php
/*
create_messages_table.inc
 
Created By: Nathan Bubb
 
11/7/2016
*/
 
 
function createMessagesTable($conn){
 
    $statement =
 
    "create table Messages(
 
msg_id Integer not null auto_increment,
 
primary key (msg_id),          


msg_text varchar(500) not null,


msg_imagepath varchar(10),


device_id Integer not null,


msg_date datetime not null,
 
msg_gps_lat varchar(15),


msg_gps_lon varchar(15),


msg_comments varchar(1000),


foreign key (device_id) references Devices(device_id)  on delete cascade
 
) ENGINE=InnoDB";
    
    if(!$result = mysqli_query($conn, $statement)){
        
        echo "\nThere was an error creating the MessagesTable";
        echo "Please contact the System Administrator";
        return false;
    } else {
        mysqli_free_result($result);
        echo "\nMessages Table was created successfully.";
        return true;
    }
}
 
?>