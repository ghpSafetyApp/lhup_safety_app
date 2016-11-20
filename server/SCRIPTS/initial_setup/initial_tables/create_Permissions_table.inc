<?php
/*


create_permissions_table.inc


Created By: William Grove


11/18/2016

*/




function createPermissionsTable($conn){


    $statement =


    "create table Permissions (


perm_id Integer not null auto_increment,


primary key (perm_id),


user_id integer not null,


perm_admin integer not null,


perm_users integer not null,


perm_end_users integer not null,


perm_calls integer not null,


perm_messages integer not null,


perm_devices integer not null,


perm_audit integer not null,
            
unique(user_id),            
            
foreign key (user_id) references Users(user_id) on delete cascade


)";


    if(!$result = mysqli_query($conn, $statement)){
        
        echo "\n<p>There was an error creating the Permissions Table";
        echo "Please contact the System Administrator</p>";
        return false;
    } else {
        mysqli_free_result($result);
        echo "\n<p>Permissions Table was created successfully.</p>";
        return true;
    }
}


?>