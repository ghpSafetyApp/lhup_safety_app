<?php
/*
 *  index.php   
 *
 *  Created By: William Grove
 *  For the Global Honors Program at
 *  Lock Haven University of Pennsylvania
 *
 *  Created On: 5/16/2016
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
<div class="news">
<div class="news-table-wrapper">
<div class="news-table">
<div class="news-table-cell">
<span class="heading_text">News</span>
</div>



<?php 
/*
$result = mysqli_query($conn, "SELECT news_title, DATE_FORMAT(news_date, '%W, %M %D, %Y'), news_text FROM news Order BY news_date desc");

if($result === false || mysqli_num_rows($result) < 1){
	
	
	echo "<div class=\"news-table-cell\">\n";
	echo "<h5>No News Available</h5>\n";
	echo "</div>\n";
	
} else {
	
	while($row = mysqli_fetch_row($result)){
		
		echo "<div class=\"news-table-cell\">\n";
		echo "<h5>" . $row[0] . " - ". $row[1] ."</h5>\n";
		
		echo "<p class=\"story\">" . $row[2] . "</p>\n";
		echo "</div>\n";
	}
	
	
}
*/
?>
</div>
</div>
</div>
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

<div class="dates">
<div class="dates-table-wrapper">
<div class="dates-table">
<div class="dates-table-cell">
<span class="heading_text">Events</span>
</div>

<?php 
/*
$result = mysqli_query($conn, "SELECT sem_prefix FROM semesters ORDER BY sem_id desc LIMIT 1");

if(mysqli_num_rows($result) > 0){
	
	$row = mysqli_fetch_row($result);
	
	$prefix = $row[0];
	
	$resultTwo = mysqli_query($conn, "SELECT title, DATE_FORMAT(start, '%W, %M %D, %Y - %l:%i %p') FROM $prefix"."_dates where start > NOW() Order BY start LIMIT 5");
	
	if($resultTwo === false || mysqli_num_rows($resultTwo) < 1){
	
	*/
		echo "<div class=\"dates-table-cell\">\n";
		echo "<h5>No Dates Available</h5>\n";
		echo "</div>\n";
	/*
	} else {
	
		while($row = mysqli_fetch_row($resultTwo)){
	
			echo "<div class=\"dates-table-cell\">\n";
			echo "<h5>" . $row[0] . "</h5>\n";
	
			echo "<p class=\"story\">" . $row[1] . "</p>\n";
			echo "</div>\n";
		}
	
	
	}
} else {
*/
	echo "<div class=\"dates-table-cell\">\n";
	echo "<h5>No Dates Available</h5>\n";
	echo "</div>\n";
	/*
}

*/
?>

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