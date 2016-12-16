
  		
  	$(document).ready(function() {
    var menu = $("ul.droopin").menu();
  		$(function() {
 	$( "#menu" ).menu();
 });
    $(menu).mouseleave(function () {
        menu.menu('collapseAll');
  	 });	
  		
        $("li[data-linkhtml]").click(function() {
        var pagename = $(this).attr("data-stateName");
        $('#right').load('FORMS/' + pagename);
    });
});	