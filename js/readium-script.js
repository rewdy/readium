/*

Readium Theme
-------------

script.js

Readium theme javascript.

*/

// Global vars
// ---
// var for context; set to 'full' or 'mobile' to determine if other actions ought to be taken.
var context;

// Initiate Stuff
// ---
ready(function(){
	// setup UI
	setupUI();
	var s = skrollr.init();

	// set context



});

// Actions
// ---
// Calls other functions to set up the UI
function setupUI() {
	// drawer toggle
	var drawerHandle = document.getElementById('navigation-toggle-link');
	addEventListener(drawerHandle, 'click', toggleDrawer);
	// scroll to content link

	// lightbox
	// !!
	// sharing links
	setupSharing();
}

// Sets up the sharing links
function setupSharing() {
	var sharingLinks = document.querySelectorAll('.sharing-list a:not(.pinterest):not(.email)');
	if (sharingLinks) {
		for (i=0; i<sharingLinks.length; i++) {
			addEventListener(sharingLinks[i], 'click', function(e){
				href = this.getAttribute('href');
				openWindow(href, 'Share');
				e.preventDefault();
			});
		}
	}
	var pinterestLink = document.querySelector('.sharing-list a.pinterest');
	if (pinterestLink) {
		addEventListener(pinterestLink, 'click', function(e){
			faLoadingIndicator(this, 'fa-pinterest', 2000); // show loading indicator
			pinterestPinIt(); // fire of pinterest function
			e.preventDefault(); // stop default
		});
	}
}

// function to toggle the drawer
function toggleDrawer(e) {
	var controlEl = document.getElementById('control');
	var pageEl = document.getElementById('page');
	if (hasClass(controlEl, 'open')) {
		removeClass(controlEl, 'open');
		removeEventListener(page, 'click', toggleDrawer);
	} else {
		addClass(controlEl, 'open');
		setTimeout(function(){
			addEventListener(page, 'click', toggleDrawer);
		},500);
	}
	if (e) {
		e.preventDefault();
	}
}

// function to open urls in a new window (used by sharing)
function openWindow(url, title) {
	var winWidth = 700;
	var winHeight = 450;
	var left = (screen.width/2)-(winWidth/2);
	var top = (screen.height/2)-(winHeight/2);
	window.open(
		url, // url
		title, // window name
		'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, height='+winHeight+', width='+winWidth+', left='+left+', top='+top
	);
}

// pinterest action
function pinterestPinIt() {
	var e = document.createElement('script');
	e.setAttribute('type','text/javascript');
	e.setAttribute('charset','UTF-8');
	e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);
	document.body.appendChild(e);
}

// show font awesome loading indicator
function faLoadingIndicator(el, iconClass, duration) {
	icon = el.querySelector('.fa');
	removeClass(icon, iconClass);
	addClass(icon, 'fa-spinner');
	addClass(icon, 'fa-spin');
	setTimeout(function(){
		removeClass(icon, 'fa-spinner');
		removeClass(icon, 'fa-spin');
		addClass(icon, iconClass);
	}, duration);
}

// Utilities (mostly taken from http://youmightnotneedjquery.com/)
// ---
// add an event listener
function addEventListener(el, eventName, handler) {
	if (el.addEventListener) {
		el.addEventListener(eventName, handler);
	} else {
		if (el.attachEvent) {
			el.attachEvent('on' + eventName, handler);
		}
	}
}
// remove event listener
function removeEventListener(el, eventName, handler) {
	if (el.removeEventListener){
		el.removeEventListener(eventName, handler);
	} else {
		if (el.detachEvent) {
			el.detachEvent('on' + eventName, handler);
		}
	}
}
// attach a dom ready event
function ready(fn) {
	if (document.addEventListener) {
		document.addEventListener('DOMContentLoaded', fn);
	} else {
		document.attachEvent('onreadystatechange', function(){
			if (document.readyState === 'interactive') {
				fn();
			}
		});
	}
}
// class CRUD
function addClass(el, className) {
	if (el.classList) {
		el.classList.add(className)
	} else {
		el.className += ' ' + className
	}
}
function hasClass(el, className) {
	if (el.classList) {
		return el.classList.contains(className);
	} else {
		return new RegExp('(^| )' + className + '( |$)', 'gi').test(el.className);
	}
}
function removeClass(el, className) {
	if (el.classList) {
		el.classList.remove(className);
	} else {
		el.className = el.className.replace(new RegExp('(^| )' + className.split(' ').join('|') + '( |$)', 'gi'), ' ');
	}
}

// end