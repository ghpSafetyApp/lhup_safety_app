<?php
/*
 *  index.php   
 *
 *  Created By: William Grove
 *
 *  Created On: 1/28/2016
 *
 */
 session_start();
 require_once ('template.inc');

require_once 'SCRIPTS/utilities/database_connection.inc';
 
 HTML_StartHead();
 
 AddTitle("Home");

 AddCSS( "all.css" );
 AddCSS( "index.css" );
 
 HTML_EndHead();
 
 HTML_StartBody();

 Body_CreateSideNav();
 
 Body_CreateHeader( "Welcome to the GHP!" );
 
 Body_CreateStickyNav();

 $conn = DBConnect();
?>

<div class="Row">

<div class="cycle-slideshow" data-cycle-auto-height="1:1">
<div class="cycle-overlay increase_index"></div><?php 
/*
$query = "SELECT slide_name, slide_text, slide_imagename FROM image_slide WHERE slide_isactive = 1 ORDER BY slide_pos";

$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0){
	
	while($row = mysqli_fetch_row($result)){
		echo "<img src=\"IMG/slides/" . $row[2] . "\" data-cycle-title=\"" . $row[0] . "\" data-cycle-desc=\"" . $row[1] . "\">";
	}
	
} else {
*/
	echo "<img src=\"IMG/none/none.jpg\" data-cycle-title=\"No Slides\" data-cycle-desc=\"No slides are set for display\">";
	/*
}
*/
?></div>


</div>

<div class="news">
<div class="news-table-wrapper">
<div class="news-table">
<div class="news-table-cell">
<span class="heading_text">News</span>
</div>

</div>
</div>
</div>

<?php

 Body_AddScript( "jquery-1.12.3.min.js" );
 Body_AddScript( "jquery.cycle2.min.js" );
 Body_AddScript( "bootstrap.min.js" );
 Body_AddScript( "all.js" );



 
 HTML_End();
?>
