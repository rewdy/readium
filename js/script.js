/*

Readium Theme
-------------

script.js

Readium theme javascript. Uses jQuery (obviously).

*/

$(function(){
	// Drawer toggle
	$('#navigation-toggle-link').click(function(){
		$('#control').toggleClass('open');
		return false;
	});

	// Set pageTop variable for other functions to use
	window.scrolled = false;
	window.pageTop = $('html, body').scrollTop();
	$(window).scroll(function(){
		window.scrolled = true;
		window.pageTop = $('html, body').scrollTop();
	});

	// Parallax effect on header image
	var header_height = $('#site-header').not('.no-image').height();
	var backgroundOffset = 0;
	if (header_height) {
		setInterval(function(){
			if (window.pageTop < header_height) {
				backgroundOffset = (window.pageTop/2) * -1;
				$('#deco').css('background-position', 'center ' + backgroundOffset + 'px');
			}
		}, 5);
	}

	enableSharing();
});

$(window).load(function(){
	// Read line - comes in the load section because if images aren't loaded, there will be issues in calculating offsets.
	$('.readline').each(function(){
		var enabled = false;
		var line = $(this);
		var article = $(this).closest('article');
		var articleTop = article.offset().top;
		var articleBottom = articleTop + article.outerHeight();
		var calculationPadding = 400; // this is extra space to add when calculating the percentage because people don't read at the top of their screens.

		// checked if the page has scrolled and sets the readline accordingly
		setInterval(function(){
			if (window.scrolled) {
				var top = window.pageTop;
				if (top >= articleTop && top <= articleBottom) {
					var percentageFinished = Math.round((top - articleTop) / (articleBottom - articleTop - calculationPadding) * 100);
					line.width(percentageFinished + '%');
				} else {
					line.width(0);
				}
			}
		}, 50);
	});
});

function enableSharing() {
	// Sharing: modal behavior and sharing links
	$('a.share-link').click(function(){
		$(this).closest('article').find('.m-share').addClass('m-show');
		return false;
	});
	$('a.perma-link').click(function(){
		$(this).closest('article').find('.m-permalink').addClass('m-show');
		return false;
	});
	$('.m-permalink input.permalink').click(function(){
		$(this).select();
		return false;
	});
	$('a.m-close-link').click(function(){
		$(this).closest('.m-show').removeClass('m-show');
		return false;
	});
	$('.sharing-list a').not('.email').click(function(){
		href = $(this).attr('href');
		openWindow(href, 'Share');
		return false;
	});
}

// function to open urls in a new window (used for sharing)
function openWindow(url, title) {
	window.open(
		url, // url
		title, // window name
		'height=450,width=700,left=50,top=50'
	);
}