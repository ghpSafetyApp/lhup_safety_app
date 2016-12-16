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


var grid = $("#grid-command-buttons-calls").bootgrid({
    ajax: true,
    post: function ()
    {
        
        return {
            id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
           
        };
    },
    url: "/SCRIPTS/ajax_files/calls/get_calls.php",
    formatters: {
        "commands": function(column, row)
        {
            
            return "<button id=\"" + row.call_id + "t0" + "\" type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.call_id + "\"><i id=\"btn" + row.call_id +"\" class=\"fa fa-pencil\"></i></button> " +
            "<button id=\"" + row.call_id + "t3" + "\" type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.call_id + "><i id=\"btn" + row.call_id + "del\" class=\"fa fa-trash-o\"></i></button>";

            	  
        },

        "call_type": function(column, row)
    	{
			//Emergency - 1
			//Danger - 2
			//Escort - 3
			//Complaint - 4
			//Report - 5
			
			//Police - 6
			//Poison Control - 7
			//Women's Center - 8
			
    		if(row.call_type == 1){
				return "Emergency";
    		}
    		
    		if(row.call_type == 2){
				return "Danger";
    		}
    		if(row.call_type == 3){
				return "Escort";
    		}
    		if(row.call_type == 4){
				return "Complaint";
    		}
    		if(row.call_type == 5){
				return "Report";
    		}
    		if(row.call_type == 6){
				return "Police";
    		}
    		if(row.call_type == 7){
				return "Poison Control";
    		}
    		if(row.call_type == 8){
				return "Women's Center";
    		}
    	},
        
    	"call_comments": function(column, row)
    	{
        	return "<textarea id=\"" + row.call_id + "t2" + "\" type=\"text\" maxlength=\"60\" class=\"form-control\" data-row-id=\"" + row.call_id+ "\" data-orig=\"" + row.call_comments + "\" >" + row.call_comments + "</textarea>";
    	},
        
        "call_date": function(column, row)
    	{
        	var t = moment(row.call_date, "YYYY-MM-DD HH:mm:ss");
        	
    		return "<input id=\"" + row.call_id + "t4" + "\" type=\"text\" class=\"form-control datepicker_dynamic\" data-row-id=\"" + row.call_id + "\" data-orig=\"" + t.format("MM/DD/YYYY hh:mm a") + "\"  value=\"" + t.format("MM/DD/YYYY hh:mm a") +  "\">";
    	}
    
    }
}).on("loaded.rs.jquery.bootgrid", function()
{
    /* Executes after data is loaded and rendered */
	grid.find(".command-delete").on("click", function(e){

    	if(confirm("Are you sure you want to remove this call?")){

    	
        	$.ajax( {
        		type: 'POST',
                url: '/SCRIPTS/web_requests/calls_request.php',
                data: {
                	'callsupdaterequest' : '1',
                	'opcode' : '2',
                	'call_id' : $(this).data("row-id")
           
                },
                dataType: "text",
                success:function(data) {
                   
                	if(data == "success"){
                		$("#grid-command-buttons-calls").bootgrid("reload");
                	} else {
                		//Do Nothing
                	}
                	
                	showMessage(data, "Call Removed.");
                	
                }
             });
    	} else {
			//Do Nothing
    	}
       
    	     }).end().find(".command-edit").on("click", function(e)
    	    		    {

    	     	var id = $(this).data("row-id");
    	         var call_comments = $("#" + id + "t2").val();
    	         
    	       
    	         
    	 		var button_id = "#btn" + id;

    	         
    	         $(button_id).removeClass("fa-pencil");
    	         $(button_id).addClass("fa-cog fa-spin");
    	     	
    	         	$.ajax( {
    	         		type: 'POST',
    	                 url: '/SCRIPTS/web_requests/calls_request.php',
    	                 data: {
    	                 	'callupdaterequest' : '1',
    	                 	'opcode' : '1',
    	                 	'call_id' : id,
    	                 	'call_comments' : call_comments
    	                 	
    	                 },
    	                 dataType: "text",
    	                 success:function(data) {

    	 					if(data == "success"){
    	 						 $("#" + id + "t2").css({"background-color": ""});
    	 				        
    	 				         $("#" + id + "t2").data({"orig": call_comments});
    	 				         
    	 					}	
    	                 	
    	                 	showMessage(data, "Call Updated");
    	                 	
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

	$(document).on('change','textarea[data-orig]',function(){
	    $(this).toggleClass("txt_change");

		var now = $(this).val();
		var orig = $(this).data("orig");

		if(now == orig){
			$(this).css({"background-color": ""});
		} else {
			$(this).css({"background-color": "#ccffcc"});
		}
    
});



$('#datetimepicker').datetimepicker({
	timeInput: true,
	timeFormat: "hh:mm tt"
});

$('#datetimepickerend').datetimepicker({
	timeInput: true,
	timeFormat: "hh:mm tt"
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

<form id="call_form" method="post" action="#" name="" class="form-horizontal">

<fieldset>

<!-- Form Name -->

<legend>Calls</legend>

</fieldset>
</form>


<table id="grid-command-buttons-calls" class="table table-condensed table-hover table-striped">
        <thead>
            <tr>
                <th data-column-id="end_user_fname"  data-type="text" >First Name</th>
                <th data-column-id="end_user_lname"  data-type="text" >Last Name</th>
                <th data-column-id="device_phone_number" data-type="text" >Number</th>
                <th data-column-id="call_comments" data-formatter="call_comments" data-type="text" >Text</th>
                <th data-column-id="call_date" data-formatter="call_date" data-type="text" >Date</th>
                <th data-column-id="call_type" data-formatter="call_type" data-type="text" >Type</th>
                <th data-column-id="call_gps_lat"  data-type="text" >Latitude</th>
                <th data-column-id="call_gps_lon"  data-type="text" >Longitude</th>
                <th data-column-id="call_id" data-type="numeric" data-identifier="true" data-visible="false">Message ID</th>
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
