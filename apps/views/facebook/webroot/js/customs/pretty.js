/*
 * JavaScript Pretty Date
 * Copyright (c) 2011 John Resig (ejohn.org)
 * Licensed under the MIT and GPL licenses.
 */

// Modified by Hieu Nguyen, 
// This function get a timestamp then convert it to pretty form

function prettyDate(time){
	var diff = (new Date()).getTime() / 1000 - time,
		day_diff = Math.round(diff / 86400);

	if(diff < 2) {		// 1 second
		return "a second ago";
	}
	if(diff < 60){		// diff is seconds
		return Math.round(diff) +  " seconds ago";
	}
	if(diff < 120){
		return "1 minute ago";
	}
	if(diff < 3600){
		diff = Math.round(diff / 60);
		return diff + " minutes ago";
	}
	if(diff < 7200){
		return "1 hour ago";
	}
	if(diff < 86400){
		diff = Math.round(diff/3600);
		return diff + " hours ago";
	}
	if(diff < 172800){
		return "1 day ago";
	}	
	if (day_diff < 7) {
		return day_diff + " days ago";		
	}
	if (day_diff < 14) {
		return "1 week ago";
	}
	if(day_diff < 32){
		return Math.round(day_diff / 7) + " weeks ago";
	}	
	if (day_diff < 63) {
		return "1 month ago";
	}
	if (day_diff < 365) {
		return Math.round(day_diff  / 31) + " months ago"
	}	
	if (day_diff < 730) {
		return " 1 year ago";
	}	
	return Math.round(day_diff / 365) + " years ago";	
}

// If jQuery is included in the page, adds a jQuery plugin to handle it as well
if ( typeof jQuery != "undefined" )
	jQuery.fn.prettyDate = function(){
		return this.each(function(){
			var date = prettyDate(this.name);
			if ( date )
				jQuery(this).text( date );
		});
	};

// use the plugin for socialewired
function updateTime() 
{
	$(".swTimeStatus").each(function (index, domEle) {		
		if (domEle.name != "") {
			var date = prettyDate(domEle.name);
			domEle.innerHTML = date;				
		}			
	});
	$(".swTimeComment").each(function (index, domEle) {			
		if (domEle.name != "") {
			var date = prettyDate(domEle.name);
			domEle.innerHTML = date;
		}			
	});
}
$(document).ready(function(){
	updateTime();		
	setInterval(function(){			
		updateTime();			
	}
	, numRand(5000, 20000));
});
function numRand($numLow, $numHigh)
{
    var adjustedHigh = (parseFloat($numHigh) - parseFloat($numLow)) + 1;
    return Math.floor(Math.random()*adjustedHigh) + parseFloat($numLow);
}


	