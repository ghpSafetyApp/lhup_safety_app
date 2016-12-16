<?php 
session_start();

require_once "../../SCRIPTS/utilities/database_connection.inc";

$conn = DBConnect();

 if(($_SESSION["permissions"][0] == 1) == false){

	header("location: index.php");
	die();
}

?><body>

<script>

$(document).ready (function(){
	
	function showMessage(result){
		 if(result === "success"){
			  $("#error_area").queue(function(){
			  $("#error_area").text("User Permissions Updated.");
			  $("#error_area").css("color", "green");
			  $("#error_area").fadeIn(500).delay( 4000 ).fadeOut(500);
			 $(this).dequeue();
			  });
			 
			  } else {
			 var err = "Error: " + result;
			  $("#error_area").queue(function(){
			   $("#error_area").text("");
			  $("#error_area").text(err);
			  $("#error_area").css("color", "red");
			  $("#error_area").fadeIn(500).delay( 4000 ).fadeOut(500);
			 $(this).dequeue();
			  })
		}
	}

    var grid = $("#grid-command-buttons-update").bootgrid({
        ajax: true,
        post: function ()
        {
            return {
                id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
            };
        },
        url: "SCRIPTS/ajax_files/permissions/get_permissions.php",
        formatters: {
            "commands": function(column, row)
            {
                return "<button id=\"" + row.perm_id + "t0" + "\" type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.perm_id + "\"><i id=\"btn" + row.perm_id +"\" class=\"fa fa-pencil\"></i></button> ";
            },                                            
            
        	"perm_users": function(column, row)
        	{
        		var widget_string = "";
        		
        		 widget_string = "<select id=\"" + row.perm_id + "t1" + "\" class=\"form-control\" name=\"perm_users\" data-orig=\"" + row.perm_users + "\" >";
        		
        		if(row.perm_users == 0){
        			 widget_string += "<option value=\"0\" selected>No</option>";
        		} else {
        			 widget_string += "<option value=\"0\">NO</option>";
        		}
        		
        		if(row.perm_users == 1){
        			 widget_string += "<option value=\"1\" Selected>Yes</option>";
        		} else {
        			 widget_string += "<option value=\"1\">Yes</option>";
        		}
        		
        		
        		 widget_string += "</select>";
        		
        		return  widget_string;
        		
        	},

        	"perm_end_users": function(column, row)
        	{
        		var widget_string = "";
        		
        		 widget_string = "<select id=\"" + row.perm_id + "t2" + "\" class=\"form-control\" name=\"perm_end_users\" data-orig=\"" + row.perm_end_users + "\" >";
        		
        		if(row.perm_end_users == 0){
        			 widget_string += "<option value=\"0\" selected>No</option>";
        		} else {
        			 widget_string += "<option value=\"0\">NO</option>";
        		}
        		
        		if(row.perm_end_users == 1){
        			 widget_string += "<option value=\"1\" Selected>Yes</option>";
        		} else {
        			 widget_string += "<option value=\"1\">Yes</option>";
        		}
        		
        		
        		 widget_string += "</select>";
        		
        		return  widget_string;
        		
        	},

        	"perm_calls": function(column, row)
        	{
        		var widget_string = "";
        		
        		 widget_string = "<select id=\"" + row.perm_id + "t3" + "\" class=\"form-control\" name=\"perm_calls\" data-orig=\"" + row.perm_calls + "\" >";
        		
        		if(row.perm_calls == 0){
        			 widget_string += "<option value=\"0\" selected>No</option>";
        		} else {
        			 widget_string += "<option value=\"0\">NO</option>";
        		}
        		
        		if(row.perm_calls == 1){
        			 widget_string += "<option value=\"1\" Selected>Yes</option>";
        		} else {
        			 widget_string += "<option value=\"1\">Yes</option>";
        		}
        		
        		
        		 widget_string += "</select>";
        		
        		return  widget_string;
        		
        	},

        	"perm_messages": function(column, row)
        	{
        		var widget_string = "";
        		
        		 widget_string = "<select id=\"" + row.perm_id + "t4" + "\" class=\"form-control\" name=\"perm_messages\" data-orig=\"" + row.perm_messages + "\" >";
        		
        		if(row.perm_messages == 0){
        			 widget_string += "<option value=\"0\" selected>No</option>";
        		} else {
        			 widget_string += "<option value=\"0\">NO</option>";
        		}
        		
        		if(row.perm_messages == 1){
        			 widget_string += "<option value=\"1\" Selected>Yes</option>";
        		} else {
        			 widget_string += "<option value=\"1\">Yes</option>";
        		}
        		
        		
        		 widget_string += "</select>";
        		
        		return  widget_string;
        		
        	},

        	"perm_devices": function(column, row)
        	{
        		var widget_string = "";
        		
        		 widget_string = "<select id=\"" + row.perm_id + "t5" + "\" class=\"form-control\" name=\"perm_devices\" data-orig=\"" + row.perm_devices + "\" >";
        		
        		if(row.perm_devices == 0){
        			 widget_string += "<option value=\"0\" selected>No</option>";
        		} else {
        			 widget_string += "<option value=\"0\">NO</option>";
        		}
        		
        		if(row.perm_devices == 1){
        			 widget_string += "<option value=\"1\" Selected>Yes</option>";
        		} else {
        			 widget_string += "<option value=\"1\">Yes</option>";
        		}
        		
        		
        		 widget_string += "</select>";
        		
        		return  widget_string;
        		
        	},

        	"perm_audit": function(column, row)
        	{
        		var widget_string = "";
        		
        		 widget_string = "<select id=\"" + row.perm_id + "t6" + "\" class=\"form-control\" name=\"perm_audit\" data-orig=\"" + row.perm_audit + "\" >";
        		
        		if(row.perm_audit == 0){
        			 widget_string += "<option value=\"0\" selected>No</option>";
        		} else {
        			 widget_string += "<option value=\"0\">NO</option>";
        		}
        		
        		if(row.perm_audit == 1){
        			 widget_string += "<option value=\"1\" Selected>Yes</option>";
        		} else {
        			 widget_string += "<option value=\"1\">Yes</option>";
        		}
        		
        		
        		 widget_string += "</select>";
        		
        		return  widget_string;
        		
        	}
        
        }
    }).on("loaded.rs.jquery.bootgrid", function()
    {
        /* Executes after data is loaded and rendered */
        grid.find(".command-edit").on("click", function(e)
        {

        	var id = $(this).data("row-id");
            var perm_users = $("#" + id + "t1").val();
            var perm_end_users = $("#" + id + "t2").val();
            var perm_calls = $("#" + id + "t3").val();
            var perm_messages = $("#" + id + "t4").val();
            var perm_devices = $("#" + id + "t5").val();
            var perm_audit = $("#" + id + "t6").val();
			var button_id = "#btn" + id;

            //TODO
            $(button_id).removeClass("fa-pencil");
            $(button_id).addClass("fa-cog fa-spin");
        	
            	$.ajax( {
            		type: 'POST',
                    url: '/SCRIPTS/web_requests/permissions_request.php',
                    data: {
                    	'permissionchangerequest' : '1',
                    	'opcode' : '1',
                    	'perm_id' : id,
                    	'perm_users' : perm_users,
                    	'perm_end_users' : perm_end_users,
                    	'perm_calls' : perm_calls,
                    	'perm_messages' : perm_messages,
                    	'perm_devices' : perm_devices,
                    	'perm_audit' : perm_audit
                    	
                    	
                    },
                    dataType: "text",
                    success:function(data) {

						if(data === "success"){
							 $("#" + id + "t2").css({"background-color": ""});
					         $("#" + id + "t1").css({"background-color": ""});
					         $("#" + id + "t3").css({"background-color": ""});
					         $("#" + id + "t4").css({"background-color": ""});
					         $("#" + id + "t5").css({"background-color": ""});
					         $("#" + id + "t6").css({"background-color": ""});
							 $("#" + id + "t1").data({"orig": perm_users});
					         $("#" + id + "t2").data({"orig": perm_end_users});
					         $("#" + id + "t3").data({"orig": perm_calls });
					         $("#" + id + "t4").data({"orig": perm_messages });
					         $("#" + id + "t5").data({"orig": perm_devices });
					         $("#" + id + "t6").data({"orig": perm_audit });
					       
						}	
                    	
                    	showMessage(data);
                    	
                    }
                 });
            	
            	$(button_id).removeClass("fa-cog fa-spin");
            	$(button_id).addClass("fa-pencil");
        });
    });


    $(document).on('change','input[data-orig]',function(){
        $(this).toggleClass("txt_change");

		var now = $(this).val();
		var orig = $(this).data("orig");

		if(now == orig){
			$(this).css({"background-color": ""});
		} else {
			$(this).css({"background-color": "#ccffcc"});
		}
		
		
        
    });

    $(document).on('change','select[data-orig]',function(){
        $(this).toggleClass("txt_change");

		var now = $(this).val();
		var orig = $(this).data("orig");

		if(now == orig){
			$(this).css({"background-color": ""});
		} else {
			$(this).css({"background-color": "#ccffcc"});
		}
		
		
        
    });
	
});

</script>



   

    

    <table id="grid-command-buttons-update" class="table table-condensed table-hover table-striped">
        <thead>
            <tr>
            	<th data-column-id="user_id" data-type="numeric" data-visible="false">User ID</th>
            	<th data-column-id="user_fname">First Name</th>
                <th data-column-id="user_lname" data-order="desc">Last Name</th>
                <th data-column-id="perm_users" data-type="numeric" data-formatter="perm_users">Users</th>
				<th data-column-id="perm_end_users" data-type="numeric" data-formatter="perm_end_users">Students</th>
                <th data-column-id="perm_calls" data-formatter="perm_calls" >Calls</th>
                <th data-column-id="perm_messages" data-formatter="perm_messages" >Messages</th>
                <th data-column-id="perm_devices" data-formatter="perm_devices" >Devices</th>
                <th data-column-id="perm_audit" data-formatter="perm_audit" >Audit</th>
                <th data-column-id="perm_id" data-type="text">Perm ID</th>
				<th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
                
            </tr>
        </thead>
    </table>

<div class="form-group">
  <label class="col-md-4 control-label" for="error_area"></label>
  <div class="col-md-4">                     
    <span id="error_area"></span>
  </div>
</div>





</body>