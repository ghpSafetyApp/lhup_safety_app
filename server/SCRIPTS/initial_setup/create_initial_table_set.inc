ls<?php

/*
 * create_initial_table_set.inc
 *
 * Created By: William Grove
 *
 * Date: 11/18/2016
 *
 * Calls the scripts to create the initial
 * table set. Caution: These tables have
 * no data, not even the admin user.
 *
 */

// Table scripts - Call functions in this order
require "initial_tables/create_Users_table.inc";
require "initial_tables/create_Audit_table.inc";
require "initial_tables/create_Permissions_table.inc";
require "initial_tables/create_EndUsers_table.inc";
require "initial_tables/create_Devices_table.inc";
require "initial_tables/create_Messages_table.inc";
require "initial_tables/create_Calls_table.inc";

// Drops the tables in the case of error
// Faster for the admin to recover.
// ONLY USE THIS FUNCTION IN THIS FILE.
require "drop_initial_tables.inc";
function createInitialTableSet($conn) {
	
	// Make sure the tables are
	// Created in this order!
	if (createUsersTable ( $conn )) {
		
		if (createAuditTable ( $conn )) {
			
			if (createPermissionsTable ( $conn )) {
				
				if (createEndUsersTable ( $conn )) {
					
					if (createDevicesTable ( $conn )) {
						
						if (createMessagesTable ( $conn )) {
							
							if (createCallsTable ( $conn )) {
								
								/*
								 * If all tables are made successfully,
								 * return true.
								 */
								
								return true;
							}
						}
					}
				}
			}
		}
	}
	
	/*
	 * Else, drop the tables,
	 * faster for admin to recover.
	 * ONLY USE THIS FUNCTION HERE.
	 */
	
	dropInitialTables_asldkfffignrmsdmsicigfjkdo ( $conn );
	
	return false;
}

?>