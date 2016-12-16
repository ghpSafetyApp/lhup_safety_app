<?php 
session_start();

require_once "../../SCRIPTS/utilities/database_connection.inc";

$conn = DBConnect();

if(($_SESSION["permissions"][0] == 1 || $_SESSION["permissions"][1] == 1 || $_SESSION["permissions"][5] == 1) == false){
	
	header("location: index.php");
	die();
}

?><body>

<script type="text/javascript">



$(document).ready (function(){

	function showMessage(result, success){
		 if(result === "success"){
			  $("#error_area").queue(function(){
			  $("#error_area").text(success);
			  $("#error_area").css("color", "green");
			  $("#error_area").fadeIn(2000).delay( 6000 ).fadeOut(2000);
			 $(this).dequeue();
			  });
			 
			  } else {
			 var err = "Error: " + result;
			  $("#error_area").queue(function(){
			   $("#error_area").text("");
			  $("#error_area").text(err);
			  $("#error_area").css("color", "red");
			  $("#error_area").fadeIn(2000).delay( 6000 ).fadeOut(2000);
			 $(this).dequeue();
			  })
		}
	}


var grid = $("#grid-command-buttons-students").bootgrid({
    ajax: true,
    post: function ()
    {
        
        return {
            id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
        };
    },
    url: "/SCRIPTS/ajax_files/students/get_students.php",
    formatters: {
        "commands": function(column, row)
        {
            
            return "<button id=\"" + row.end_user_id + "t0" + "\" type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.end_user_id + "\"><i id=\"btn" + row.end_user_id +"\" class=\"fa fa-pencil\"></i></button> " +
            "<button id=\"" + row.end_user_id + "t3" + "\" type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.end_user_id + "\" data-event-name=\"" + row.acad_title +"\"><i id=\"btn" + row.end_user_id + "del\" class=\"fa fa-trash-o\"></i></button>";

            	  
        },
        
       
    	"end_user_status": function(column, row)
    	{
    		var active_string = "";
    		
    		active_string = "<select id=\"" + row.end_user_id + "t5" + "\" class=\"form-control\" name=\"education\" data-orig=\"" + row.end_user_status + "\" data-row-id=\"" + row.end_user_id + "\">";
    		
    		if(row.end_user_status == 1){
    			active_string += "<option value=\"1\" selected>Pending</option>";
    		} else {
    			active_string += "<option value=\"1\">Pending</option>";
    		}
    		
    		if(row.end_user_status == 2){
    			active_string += "<option value=\"2\" Selected>Active</option>";
    		} else {
    			active_string += "<option value=\"2\">Active</option>";
    		}
    		
    		if(row.end_user_status == 3){
    			active_string += "<option value=\"3\" Selected>Banned</option>";
    		} else {
    			active_string += "<option value=\"3\">Banned</option>";
    		}
    		
    		active_string += "</select>";
    		
    		return active_string;
    		
    	}
    
    }
}).on("loaded.rs.jquery.bootgrid", function()
{
    /* Executes after data is loaded and rendered */
	grid.find(".command-delete").on("click", function(e){

    	if(confirm("Are you sure you want to remove the end user?")){

    	
        	$.ajax( {
        		type: 'POST',
                url: '/SCRIPTS/web_requests/enduser_request.php',
                data: {
                	'enduserupdaterequest' : '1',
                	'opcode' : '2',
                	'end_user_id' : $(this).data("row-id"),
           
                },
                dataType: "text",
                success:function(data) {
                   
                	if(data == "success"){
                		$("#grid-command-buttons-students").bootgrid("reload");
                	} else {
                		//Do Nothing
                	}
                	
                	showMessage(data, "Student Removed.");
                	
                }
             });
    	} else {
			//Do Nothing
    	}
       
    	     }).end().find(".command-edit").on("click", function(e)
    	    		    {

    	     	var id = $(this).data("row-id");
    	        var end_user_status = $("#" + id + "t5").val();
    	 		var button_id = "#btn" + id;
    	         
    	         $(button_id).removeClass("fa-pencil");
    	         $(button_id).addClass("fa-cog fa-spin");
    	     	
    	         	$.ajax( {
    	         		type: 'POST',
    	                 url: '/SCRIPTS/web_requests/enduser_request.php',
    	                 data: {
    	                 	'enduserupdaterequest' : '1',
    	                 	'opcode' : '1',
    	                 	'end_user_id' : id,
    	                 	'end_user_status' : end_user_status
    	                 	
    	                 },
    	                 dataType: "text",
    	                 success:function(data) {

    	 					if(data == "success"){
    	 						 $("#" + id + "t5").css({"background-color": ""});
    	 				        
    	 				         $("#" + id + "t5").data({"orig": end_user_status});
    	 				         
    	 					}	
    	                 	
    	                 	showMessage(data, "Student Updated");
    	                 	
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

});






</script>

<form id="student_form" method="post" action="#" name="" class="form-horizontal">

<fieldset>

<!-- Form Name -->

<legend>Students</legend>

</fieldset>
</form>


<table id="grid-command-buttons-students" class="table table-condensed table-hover table-striped">
        <thead>
            <tr>
                <th data-column-id="end_user_fname"  data-type="text" >First Name</th>
                <th data-column-id="end_user_lname"  data-type="text" >Last Name</th>
                <th data-column-id="end_user_status" data-type="text" data-formatter="end_user_status">Status</th>
                <th data-column-id="end_user_username" data-type="text" >Username</th>
                <th data-column-id="end_user_hash" data-type="text" >Hash</th>
                <th data-column-id="end_user_password" data-type="text" data-visible="false">Password</th>
                <th data-column-id="end_user_id" data-type="numeric" data-identifier="true" data-visible="false">Message ID</th>
                <th data-column-id="commands" data-formatter="commands" data-sortable="false" >Commands</th>
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
