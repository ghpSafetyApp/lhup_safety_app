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


var grid = $("#grid-command-buttons-devices").bootgrid({
    ajax: true,
    post: function ()
    {
        
        return {
            id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
           
        };
    },
    url: "/SCRIPTS/ajax_files/devices/get_devices.php",
    formatters: {
        "commands": function(column, row)
        {
            
            return "<button id=\"" + row.device_id + "t0" + "\" type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.device_id + "\"><i id=\"btn" + row.device_id +"\" class=\"fa fa-pencil\"></i></button> " +
            "<button id=\"" + row.device_id + "t3" + "\" type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.device_id + "\" data-event-name=\"" + row.acad_title +"\"><i id=\"btn" + row.device_id + "del\" class=\"fa fa-trash-o\"></i></button>";

            	  
        },
        
        "device_register_date": function(column, row)
    	{
        	var t = moment(row.device_register_date, "YYYY-MM-DD HH:mm:ss");
        	
    		return "<input id=\"" + row.device_id + "t4" + "\" type=\"text\" class=\"form-control datepicker_dynamic\" data-row-id=\"" + row.device_id + "\" data-orig=\"" + t.format("MM/DD/YYYY hh:mm a") + "\"  value=\"" + t.format("MM/DD/YYYY hh:mm a") +  "\">";
    	},
    	"device_active": function(column, row)
    	{
    		var active_string = "";
    		
    		active_string = "<select id=\"" + row.device_id + "t5" + "\" class=\"form-control\" name=\"education\" data-orig=\"" + row.device_active + "\" data-row-id=\"" + row.device_id + "\">";
    		
    		if(row.device_active == 1){
    			active_string += "<option value=\"1\" selected>Pending</option>";
    		} else {
    			active_string += "<option value=\"1\">Pending</option>";
    		}
    		
    		if(row.device_active == 2){
    			active_string += "<option value=\"2\" Selected>Active</option>";
    		} else {
    			active_string += "<option value=\"2\">Active</option>";
    		}
    		
    		if(row.device_active == 3){
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

    	if(confirm("Are you sure you want to remove the Device?")){

    	
        	$.ajax( {
        		type: 'POST',
                url: '/SCRIPTS/web_requests/device_request.php',
                data: {
                	'deviceupdaterequest' : '1',
                	'opcode' : '2',
                	'device_id' : $(this).data("row-id"),
           
                },
                dataType: "text",
                success:function(data) {
                   
                	if(data == "success"){
                		$("#grid-command-buttons-devices").bootgrid("reload");
                	} else {
                		//Do Nothing
                	}
                	
                	showMessage(data, "Device Removed.");
                	
                }
             });
    	} else {
			//Do Nothing
    	}
       
    	     }).end().find(".command-edit").on("click", function(e)
    	    		    {

    	     	var id = $(this).data("row-id");
    	        var device_active = $("#" + id + "t5").val();
    	 		var button_id = "#btn" + id;
    	         
    	         $(button_id).removeClass("fa-pencil");
    	         $(button_id).addClass("fa-cog fa-spin");
    	     	
    	         	$.ajax( {
    	         		type: 'POST',
    	                 url: '/SCRIPTS/web_requests/device_request.php',
    	                 data: {
    	                 	'deviceupdaterequest' : '1',
    	                 	'opcode' : '1',
    	                 	'device_id' : id,
    	                 	'device_active' : device_active
    	                 	
    	                 },
    	                 dataType: "text",
    	                 success:function(data) {

    	 					if(data == "success"){
    	 						 $("#" + id + "t5").css({"background-color": ""});
    	 				        
    	 				         $("#" + id + "t5").data({"orig": device_active});
    	 				         
    	 					}	
    	                 	
    	                 	showMessage(data, "Device Updated");
    	                 	
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


$( '#datetimepicker' ).change(function() {

	var newtime = $('#datetimepicker').datetimepicker('getDate');
	
	newtime.setHours(newtime.getHours() + 1);
	
	$('#datetimepickerend').datetimepicker('setDate', newtime );
	
	});

$('body').on('focus',".datepicker_dynamic", function(){
    $(this).datetimepicker({
    	timeInput: true,
    	timeFormat: "hh:mm tt"
    });

	
    
});

});






</script>

<form id="devices_form" method="post" action="#" name="" class="form-horizontal">

<fieldset>

<!-- Form Name -->

<legend>Devices</legend>

</fieldset>
</form>


<table id="grid-command-buttons-devices" class="table table-condensed table-hover table-striped">
        <thead>
            <tr>
                <th data-column-id="end_user_fname"  data-type="text" >First Name</th>
                <th data-column-id="end_user_lname"  data-type="text" >Last Name</th>
                <th data-column-id="device_mac" data-type="text" >MAC</th>
                <th data-column-id="device_phone_number" data-type="text" >Phone</th>
                <th data-column-id="device_register_date" data-formatter="device_register_date" data-type="text" >Date</th>
                <th data-column-id="device_hash" data-type="text" >Hash</th>
                <th data-column-id="device_active" data-formatter="device_active" data-type="numeric" >Status</th>
                <th data-column-id="device_id" data-type="numeric" data-identifier="true" data-visible="false">Message ID</th>
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
