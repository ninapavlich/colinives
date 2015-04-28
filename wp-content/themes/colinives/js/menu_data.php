<?php
header("Content-type: text/javascript");

define('WP_USE_THEMES', false);

/** Loads the WordPress Environment and Template */
require('../../../../wp-blog-header.php');


$menuitems = getGlobalMenuItems();

?>

var menu_items = <?php echo json_encode($menuitems); ?>;

var currPage = '';
var inited = false;
var originalTitle = '';
var originalSubtitle = '';
var menuButtons = [];
var initialMouseX = -1;
var initialMouseY = -1;
var mouseX;
var mouseY;


var clickLinkTimeout;
var isIEOld = false;
var showFullMenu = true;
var window_focus = true;
var xmultiplier = 0;

var menuoffset = 0;
var menu_width = 0;
var menu_element_width = 130; //magic number
var thumbnail_offset = 0;
	
$(document).mousemove(function(e) { 
	updateMousePosition(e);
});
	
$(document).ready(function() {
	init();
});
function init(){
	if(inited) return;
	
	//detect IE8 and 7
	if ($.browser.msie) {
		if(parseInt($.browser.version, 10) === 7 || parseInt($.browser.version, 10) === 8){
			isIEOld = true;
		}
	}
	populateMenu();
	initMenu();
	
	
	$(window).bind( 'resize', function(){
		updateMenuVisibility();
	});
		
	
	
	$(document).mousemove(function(e) { 
		updateMousePosition(e);
    });
	updateMenuButtons();
	
	updateMenuVisibility();
	inited = true;
	initLinks();

	 /*	BLUR AND FOCUS EVENTS -- I put several lissteners to cover all the bases -- i'm not sure how browser support will shake onfocusout*/
	$(window).focus(function() {  onFocus(); });
    $(window).blur(function() { onBlur(); });
	if ($.browser.msie) { // check for Internet Explorer
		document.onfocusin = onFocus;
		document.onfocusout = onBlur;
	} else {
		window.onfocus = onFocus;
		window.onblur = onBlur;
	}

	setInterval(updateMenuButtons, 100);
	
	
}
function onFocus(){
	window_focus = true;
}
function onBlur(){
	window_focus = false;
}
function updateMenuVisibility(){
	var winw = $(window).width();
	if(winw < 980){
		
		showFullMenu = false;
		$('.mobile-menu').show();
		$('.fancy-menu').hide();
		
	}else{
		showFullMenu = true;
		$('.mobile-menu').hide();
		$('.fancy-menu').show();
	}
}
function updateMousePosition(e){
	mouseX = e.pageX;
	mouseY = e.pageY;


	var window_width = $(window).width();

	var left_portion = 0.2 * window_width;
	var right_portion = 0.8 * window_width;
	var top_section = 200;
	if(mouseX <= left_portion && mouseY < top_section){
		//mouse is on left side of screen
		var strength_left = 1 - (mouseX / left_portion); //how close the the left edge are you

		var speed = 30 * strength_left;

		xmultiplier = xmultiplier + ((speed-xmultiplier)/5);

		
	}else if(mouseX >= right_portion && mouseY < top_section){
		var strength_right = ((mouseX-right_portion) / left_portion); //how close the the left edge are you
		var speed = -30 * strength_right;
		//mouse is on right side of screen
		xmultiplier = xmultiplier + ((speed-xmultiplier)/5);

	}else{
		xmultiplier = xmultiplier + (0-xmultiplier)/6;
		if( Math.abs(xmultiplier)<1) {
			xmultiplier = 0;
		}	
	}
	
	//log(xmultiplier)
	onFocus(); //if we're receiving mouse events, turn focus on

}
function updateMenuButtons(){
	//This funciton is expensive, so only do it when menu is active and has focus
	if(showFullMenu==false) return;
	if(window_focus==false) return;
	
	//update size of buttons
	for(var k = 0; k<menuButtons.length; k++){
		var button = menuButtons[k];
		
		var distance = calculateDistance(button, mouseX, mouseY);
		var scale = distanceToScale(distance);
		animateMenuButton(button, scale, 0);
	}


	//center the menu container
	var window_width = $(window).width();
	var labels = $('.menu-labels ul');
	var thumbnails = $('.colinives-menu ul');
	
	var xvalue = 0.5 * (window_width - menu_width);
	

	menuoffset += xmultiplier;
	xvalue = (xvalue + menuoffset);

	var min_x = (window_width*0.5) - menu_width;
	var max_x = (window_width*0.5) ;
	xvalue = Math.max(min_x, xvalue);
	xvalue = Math.min(max_x, xvalue);
	
	thumbnail_offset = xvalue;

	labels.css('marginLeft', thumbnail_offset + 'px');
	thumbnails.css('marginLeft', thumbnail_offset + 'px');

	 //log("xvalue = "+xvalue)
	//log("xvalue: "+xvalue+" min_x: "+min_x+" max_x: "+max_x);
	//$('.fancy-menu').marginLeft = ;
}
function distanceToScale(distance){
	var min_threshold = 40;
	var max_threshold = 300;
	var min_scale = .05;
	
	var dist_bottom = Math.max(0, distance - min_threshold);
	var portion = Math.min(1, dist_bottom / max_threshold);
	var reverse = Math.max(min_scale, 1 - portion);
	//console.log("dist = "+distance+" dist_bottom = "+dist_bottom+" portion = "+portion+" reverse = "+reverse);
	return reverse;
	
}
function calculateDistance(elem, mouseX, mouseY) {
	//x distance
	//return Math.abs(mouseX - (elem.offset().left+(elem.width()/2)));
	
	//actual distance
	return Math.floor(Math.sqrt(Math.pow(mouseX - (elem.offset().left+(elem.width()/2)), 2) + Math.pow(mouseY - (elem.offset().top+(elem.height()/2)), 2)));
}
function initFades(){
	
}
function initLinks(){
	
	//add jquery click events....
	$('.colinives-menu').find('li').each(function(){
		
		var link = $(this).find('a').get(0);
        var linkHref= $(link).attr('href');
		var linkTitle= $(link).attr('title');
		menuButtons.push($(this));
		
		
		//Static, simple resizing
		$(this).mouseover(function(event) {
			//animateMenuButton(this, 1);
			
			animateLabel(this, true);
		});
		
		$(this).mouseout(function(event) {
			
			//var linkClass = $(this).attr('class');
			//var scale = (linkClass=='active')? 1 : .15;
			//animateMenuButton(this, scale);
			
			animateLabel(this, false);
		});
		
		
		
		
	});
	
}
function populateMenu(){
	for (var i = 0; i < menu_items.length; i++) {
		var menu_item = menu_items[i];

		$(".mobile-menu ul").append(createMenuLabel(menu_item));
		$(".menu-labels ul").append(createMenuLabel(menu_item));
		$(".colinives-menu ul").append(createThumbnailMenu(menu_item));
	}

}
function createMenuLabel(menu_item){
	return '<li><a href="./#/'+menu_item.slug+'">'+menu_item.name+'</a></li>';
}
function createThumbnailMenu(menu_item){
	return '<li><a href="./#/'+menu_item.slug+'"><img src="'+menu_item.thumbnail_image+'" alt="'+menu_item.thumbnail_title+'" ></a></li>';
}
function initMenu(){
	
	
	//add jquery click events....
	$('.colinives-menu').find('li').each(function(){
		
		var link = $(this).find('a').get(0);
        var linkHref= $(link).attr('href');
		var linkTitle= $(link).attr('title');
		
		//INTIALIZE SIZE
		var linkClass = $(this).attr('class');
		var scale = (linkClass=='active')? 1 : .15;
		animateMenuButton(this, scale, 0);
		
		animateLabel(this, false, 0);
		
		
		
	});

	var count = $('.colinives-menu').find('li').length;
	menu_width = count * menu_element_width;
	
}

function animateLabel(item, fadeIn, duration){
	
	var link = $(item).find('a').get(0);
	var linkHref= $(link).attr('href');
		
	var lofilink = $('.menu-labels').find('a[href$='+linkHref+']').get(0);
	
	var value = ( fadeIn == true ) ? 1 : 0;
	var overrideDuration = (typeof duration === "undefined") ? -1 : duration;
	var dur = (overrideDuration==-1) ? (value==1? 400 : 200) : overrideDuration;
	
	var max_height = 83;
	var max_width = 110;
	var browserOffset = (isIEOld == true)? 0 : 8;
	var link_width = $(lofilink).width();
	var link_height = $(lofilink).height();
	var offsetY = 0.5 * (max_height - link_height);
	var offsetX = ( 0.5 * ( max_width - link_width ) ) + browserOffset;
	
	$(lofilink).stop();

	//$(lofilink).css('marginTop', offsetY + 'px');
	//$(lofilink).css('marginLeft', offsetX + 'px');
	
	$(lofilink).animate({
		opacity: value
	}, dur);
	
}
function animateMenuButton(item, scale, duration){
	
	
	var max_height = 83;
	var max_width = 110;
	var img = $(item).find('img').get(0);
			
	var actual_portion = scale;
	var actual_height = max_height * actual_portion;
	var actual_width = max_width * actual_portion;
	
		
	var offsetY = 0.5 * (max_height - actual_height);
	var offsetX = ( 0.5 * ( max_width - actual_width ) );
	
	var overrideDuration = (typeof duration === "undefined") ? -1 : duration;
	var dur = (overrideDuration==-1) ? (scale==1? 250 : 600) : overrideDuration;
	
	
	$(img).stop();

	
	
	$(img).animate({
		height: actual_height,
		marginTop: offsetY,
		marginLeft: offsetX
	}, dur);

}




function log(message){
	try{
		console.log(message);
	}catch(e){}
}