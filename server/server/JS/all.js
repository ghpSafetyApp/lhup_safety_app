/*
 *  all.js
 *
 *  Created By: William Grove
 *
 *  Created On: 5/16/2016
 *   
 */

function openNav() {
    document.getElementById("mySidenav").style.width = "50%";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

function sticky_relocate() {
    var window_top = $(window).scrollTop();
    var div_top = $('#sticky-anchor').offset().top;
    if (window_top > div_top)
        $('#navbar').addClass('sticky');
    else
        $('#navbar').removeClass('sticky');
}

$(function() {
    $(window).scroll(sticky_relocate);
    sticky_relocate();
});

function acceptLogout() {
        var conf = confirm("Are you sure you want to Log Out?");
        return conf;
}


