/*

Readium Theme
-------------

script.js

Readium theme javascript.

*/

// Global vars
// ---
// var for context; set to 'full' or 'mobile' to determine if other actions ought to be taken.
window.context;

// Initiate Stuff
// ---
jQuery(function(){
	// setup UI
	setupUI();
	// set context
	setupSizeContext();
});

// Initiate page-size related stuff
jQuery(window).load(function(){
	// context setup
	window.pageTop = 0;
	$window = jQuery(window);
	jQuery(window).scroll(function(){
		window.pageTop = $window.scrollTop();
	});

	// header parallax setup
	setupParallax();

	// readline setup
	setupReadline();
});


// Actions
// ---
// Calls other functions to set up the UI
function setupUI() {
	// drawer toggle
	var $drawerHandle = jQuery('#navigation-toggle-link');
	$drawerHandle.click(toggleDrawer);

	// scroll to content link
	setupScrollToContent();

	// lightbox
	setupLightbox();

	// sharing links
	setupSharing();
}

// Sets up the sharing links
function setupSharing() {
	$sharingLinks = jQuery('.sharing-list a:not(.pinterest):not(.email)');
	$sharingLinks.click(function(e){
		href = this.getAttribute('href');
		openWindow(href, 'Share');
		e.preventDefault();
	});
	var $pinterestLink = jQuery('.sharing-list a.pinterest');
	$pinterestLink.click(function(e){
		faLoadingIndicator(jQuery(this), 'fa-pinterest', 2000); // show loading indicator
		pinterestPinIt(); // fire of pinterest function
		e.preventDefault(); // stop default
	});
}

// Sets up parallax on the header
function setupParallax() {
	$siteHeader = jQuery('#site-header');
	$headerOverlay = jQuery('#page-header-overlay');

	var headerHeight = $siteHeader.not('.no-image').height();
	var bgOffset = 0;
	if (headerHeight) {
		jQuery(window).scroll(function(){
			if (window.context == 'full') {
				if (window.pageTop < headerHeight) {
					// header image stuff
					bgOffset = Math.abs(window.pageTop/2) * -1;
					$siteHeader.css('background-position', 'center ' + bgOffset + 'px');

					// header overlay stuff
					titleBottomOffset = (headerHeight-window.pageTop)/4; // 25% in px which is the default
					titleMinBottomOffset = 80;
					//titleBottomOffset = (titleBottomOffset > titleMinBottomOffset) ? titleBottomOffset : titleMinBottomOffset;
					opacity = (titleBottomOffset/headerHeight*4) + 0.2;
					opacity = (opacity > 1) ? 1 : opacity; // block values > 1;
					$headerOverlay.css('bottom', titleBottomOffset + 'px').css('opacity', opacity);
				}
			}
		});

		// re-set stuff if window gets resized;
		jQuery(window).resize(function(){
			headerHeight = $siteHeader.not('.no-image').height();
			if (window.context == 'mobile') {
				$siteHeader.css('background-position', 'center 0');
				$headerOverlay.css('bottom', '25%').css('opacity', 1);
			}
		});
	}
}

// Sets up scroll to content link
function setupScrollToContent() {
	jQuery('#content-link').click(function(){
		var destinationSel = jQuery(this).attr('href');
		var contentTop = jQuery(destinationSel).offset().top;
		jQuery('body,html').animate({
			scrollTop:contentTop
		}, 700);
		return false;
	});
}

// Sets up the readline
function setupReadline() {
	jQuery('.readline').each(function(){
		var enabled = false;
		var line = jQuery(this);
		var article = jQuery(this).closest('article');
		var articleTop = article.offset().top;
		var articleBottom = articleTop + article.outerHeight();
		// reset top and bottom for window resize
		jQuery(window).resize(function(){
			articleTop = article.offset().top;
			articleBottom = articleTop + article.outerHeight();
		});
		var calculationPadding = 400; // this is extra space to add when calculating the percentage because people don't read at the top of their screens.

		// sets the readline accordingly on an interval to keep from bogging down the scroll event
		setInterval(function(){
			var top = window.pageTop;
			if (top >= articleTop && top <= articleBottom) {
				var percentageFinished = Math.round((top - articleTop) / (articleBottom - articleTop - calculationPadding) * 100);
				line.width(percentageFinished + '%');
			} else {
				line.width(0);
			}
		}, 50);
	});
}

// Sets up the lightbox
function setupLightbox() {
	jQuery('.gallery').each(function(index){
		var $gal = jQuery(this);
		var galId = $gal.attr('id');
		var $galleryLinks = $gal.find('.gallery-icon a').filter("[href$='.jpg'], [href$='.gif'], [href$='.png']");
		$galleryLinks.each(function(){
			if (jQuery(this).attr('title')!='') {
				$link = jQuery(this);
				var title = $link.find('img').attr('alt');
				$link.attr('title', title);
			}
		});
		$galleryLinks.attr('data-lightbox-gallery', galId);
		$galleryLinks.nivoLightbox({effect: 'fadeScale'});
	});
}

// function to toggle the drawer
function toggleDrawer(e) {
	var $control = jQuery('#control');
	var $page = jQuery('#page');
	if ($control.hasClass('open')) {
		$control.removeClass('open')
		$page.unbind('click', toggleDrawer)
	} else {
		$control.addClass('open');
		setTimeout(function(){
			$page.bind('blick', toggleDrawer);
		},500);
	}
	if (e) {
		e.preventDefault();
	}
}

function setupSizeContext() {
	setSizeContext();
	var sized;
	jQuery(window).resize(function(){
		sized = setTimeout(setSizeContext, 200);
	})
}
function setSizeContext() {
	// shortcut set
	$body = jQuery('body');
	// remove existing context class
	$body.removeClass(window.context);
	// get the width of the window for comparison
	var winWidth = jQuery(window).width();
	// set the context var to the new width
	window.context = (winWidth > 640) ? 'full' : 'mobile';
	// add the body class
	jQuery('body').addClass(window.context);
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
function faLoadingIndicator($el, iconClass, duration) {
	$icon = $el.find('.fa');
	$icon.removeClass(iconClass);
	$icon.addClass('fa-spinner').addClass('fa-spin');
	setTimeout(function(){
		$icon.removeClass('fa-spinner').removeClass('fa-spin');
		$icon.addClass(iconClass);
	}, duration);
}

// end