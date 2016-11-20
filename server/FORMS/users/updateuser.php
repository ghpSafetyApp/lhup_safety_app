<?php 
session_start();

require_once "../../SCRIPTS/utilities/database_connection.inc";

$conn = DBConnect();

 if(($_SESSION["permissions"][0] == 1 || $_SESSION["permissions"][1] == 1 || $_SESSION["permissions"][2] == 1) == false){

	header("location: index.php");
	die();
}

?><body>

<script>

$(document).ready (function(){
	
	function showMessage(result){
		 if(result === "success"){
			  $("#error_area").queue(function(){
			  $("#error_area").text("User Updated.");
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
        url: "/SCRIPTS/ajax_files/users/get_users.php",
        formatters: {
            "commands": function(column, row)
            {
                return "<button id=\"" + row.usr_id + "t0" + "\" type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.usr_id + "\"><i id=\"btn" + row.usr_id +"\" class=\"fa fa-pencil\"></i></button> ";
            },
        
        	"user_fname": function(column, row)
        	{
        		return "<input id=\"" + row.usr_id + "t1" + "\" type=\"text\" maxlength=\"20\" class=\"form-control\" name=\"fname\"  data-row-id=\"" + row.usr_school_id + "\" data-orig=\"" + row.usr_fname + "\" value=\"" + row.usr_fname +  "\">";
        	},
            
            "user_lname": function(column, row)
        	{
            	return "<input id=\"" + row.usr_id + "t2" + "\" type=\"text\" maxlength=\"35\" class=\"form-control\" name=\"lname\"  data-row-id=\"" + row.usr_school_id + "\" data-orig=\"" + row.usr_lname + "\" value=\"" + row.usr_lname +  "\">";
        	},

            
            "user_isactive": function(column, row)
        	{
        		var active_string = "";
        		
        		active_string = "<select id=\"" + row.usr_id + "t5" + "\" class=\"form-control\" name=\"education\" data-orig=\"" + row.usr_education + "\" data-row-id=\"" + row.usr_school_id + "\">";
        		
        		if(row.user_isactive == 1){
        			active_string += "<option value=\"1\" selected>Inactive</option>";
        		} else {
        			active_string += "<option value=\"1\">Inactive</option>";
        		}
        		
        		if(row.user_isactive == 2){
        			active_string += "<option value=\"2\" Selected>Active</option>";
        		} else {
        			active_string += "<option value=\"2\">Active</option>";
        		}
        		
        		
        		
        		active_string += "</select>";
        		
        		return active_string;
        		
        	}
        
        }
    }).on("loaded.rs.jquery.bootgrid", function()
    {
        /* Executes after data is loaded and rendered */
        grid.find(".command-edit").on("click", function(e)
        {

        	var id = $(this).data("row-id");
            var lname = $("#" + id + "t2").val();
            var fname = $("#" + id + "t1").val();
            var status = $("#" + id + "t5").val();
            
			var button_id = "#btn" + id;

            
            $(button_id).removeClass("fa-pencil");
            $(button_id).addClass("fa-cog fa-spin");
        	
            	$.ajax( {
            		type: 'POST',
                    url: '/SCRIPTS/web_requests/user_request.php',
                    data: {
                    	'userupdaterequest' : '1',
                    	'opcode' : '3',
                    	'usr_id' : id,
                    	'fname' : fname,
                    	'lname' : lname,
                    	'status' : status
                    },
                    dataType: "text",
                    success:function(data) {

						if(data === "success"){
							 $("#" + id + "t2").css({"background-color": ""});
					         $("#" + id + "t1").css({"background-color": ""});
					         $("#" + id + "t5").css({"background-color": ""});
					         $("#" + id + "t2").data({"orig": lname});
					         $("#" + id + "t1").data({"orig": fname});
					         $("#" + id + "t5").data({"orig": status });
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

<form>
<fieldset>
<legend>
Users
</legend>
</fieldset>
</form>
    <table id="grid-command-buttons-update" class="table table-condensed table-hover table-striped">
        <thead>
            <tr>
                <th data-column-id="user_fname" data-formatter="user_fname">First Name</th>
                <th data-column-id="user_lname" data-formatter="user_lname">Last Name</th>
                <th data-column-id="user_username" data-type="text">Username</th>
                <th data-column-id="user_isactive" data-type="numeric" data-formatter="user_isactive">Status</th>
                <th data-column-id="user_id" data-type="numeric" data-visible="false" data-identifier="true">User ID</th>
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
