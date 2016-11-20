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

var grid = $("#grid-command-buttons-audit").bootgrid({
    ajax: true,
    post: function ()
    {
        
        return {
            id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
           
        };
    },
    url: "/SCRIPTS/ajax_files/audit/get_audit_entries.php",
    formatters: {

        "aud_code": function(column, row)
    	{
			//Add - 1
			//Update - 2
			//Delete - 3
			
			
    		if(row.call_type == 1){
				return "Insert";
    		}
    		
    		if(row.call_type == 2){
				return "Update";
    		}
    		if(row.call_type == 3){
				return "Delete";
    		}
    	},
        
    	"aud_data": function(column, row)
    	{
        	return "<textarea id=\"" + row.aud_id + "t2" + "\" type=\"text\" maxlength=\"60\" class=\"form-control\" data-row-id=\"" + row.aud_id+ "\" data-orig=\"" + row.aud_data + "\" >" + row.aud_data + "</textarea>";
    	},
        
        "aud_date": function(column, row)
    	{
        	var t = moment(row.aud_date, "YYYY-MM-DD HH:mm:ss");
        	
    		return "<input id=\"" + row.aud_id + "t4" + "\" type=\"text\" class=\"form-control datepicker_dynamic\" data-row-id=\"" + row.aud_id + "\" data-orig=\"" + t.format("MM/DD/YYYY hh:mm a") + "\"  value=\"" + t.format("MM/DD/YYYY hh:mm a") +  "\">";
    	}
    
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

$('body').on('focus',".datepicker_dynamic", function(){
    $(this).datetimepicker({
    	timeInput: true,
    	timeFormat: "hh:mm tt"
    });

	
    
});

});






</script>

<form id="audit_form" method="post" action="#" name="" class="form-horizontal">

<fieldset>

<!-- Form Name -->

<legend>Audit</legend>

</fieldset>
</form>


<table id="grid-command-buttons-audit" class="table table-condensed table-hover table-striped">
        <thead>
            <tr>
                <th data-column-id="user_fname"  data-type="text" >First Name</th>
                <th data-column-id="user_lname"  data-type="text" >Last Name</th>
                <th data-column-id="aud_data" data-formatter="aud_data" data-type="text" >Data</th>
                <th data-column-id="aud_date" data-formatter="aud_date" data-type="text" >Date</th>
                <th data-column-id="aud_code" data-formatter="aud_code" data-type="text" >Action</th>
                <th data-column-id="aud_id" data-type="numeric" data-identifier="true" data-visible="false">Audit ID</th>
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
