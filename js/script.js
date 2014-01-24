/*

Readium Theme
-------------

script.js

Readium theme javascript. Uses jQuery (obviously).

*/

$(function(){
	// Drawer toggle
	$('#navigation-toggle-link').click(function(){
		if ($('#control').hasClass('open')) {
			$('#control').removeClass('open');
		} else {
			$('#control').addClass('open');
			$('#page').one('click', function(){
				$('#control').removeClass('open');
			})
		}
		return false;
	});

	// Set pageTop variable for other functions to use
	window.pageTop = $('html,body').scrollTop();
	$(window).scroll(function(){
		window.pageTop = $(window).scrollTop();
	});

	enableSharing();
});

$(window).load(function(){
	// Various items come in the load section because if images aren't loaded, there will be issues in calculating offsets.

	// Parallax effect on header image
	var header_height = $('#site-header').not('.no-image').height();
	var backgroundOffset = 0;
	if (header_height) {
		$(window).scroll(function(){
			if (window.pageTop < header_height) {
				backgroundOffset = Math.abs(window.pageTop/2) * -1;
				$('#site-header').css('background-position', 'center ' + backgroundOffset + 'px');
			}
		});
	}

	// Read line
	$('.readline').each(function(){
		var enabled = false;
		var line = $(this);
		var article = $(this).closest('article');
		var articleTop = article.offset().top;
		var articleBottom = articleTop + article.outerHeight();
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
});

function enableSharing() {
	$('.sharing-list a').not('.email, .pinterest').click(function(){
		href = $(this).attr('href');
		openWindow(href, 'Share');
		return false;
	});
	$('.sharing-list a.pinterest').click(function(){
		faLoadingIndicator($(this), 'fa-pinterest', 2000);
		pinterestPinIt();
		return false;
	});
}

// function to open urls in a new window (used for sharing)
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

function faLoadingIndicator($el, iconClass, duration) {
	$icon = $el.find('.fa');
	$icon.removeClass(iconClass);
	$icon.addClass('fa-spinner').addClass('fa-spin');
	setTimeout(function(){
		$icon.removeClass('fa-spinner').removeClass('fa-spin');
		$icon.addClass(iconClass);
	}, duration);
}