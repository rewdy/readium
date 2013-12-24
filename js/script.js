// Script.jss

$(function(){
	// if ($('body').hasClass('read')) {
	// 	var scrollDestination = $('#content-body').offset().top;
	// 	$('html, body').animate({scrollTop:scrollDestination}, 2000);
	// }

	// drawer toggle
	$('#navigation-toggle-link').click(function(){
		$('#control').toggleClass('open');
		return false;
	})

	// sharing stuff
	$('a.share-link').click(function(){
		$(this).closest('article').find('.m-share').addClass('m-show');
		return false;
	});
	$('a.perma-link').click(function(){
		$(this).closest('article').find('.m-permalink').addClass('m-show');
		$(this).closest('article').find('.m-permalink input.permalink').click(function(){
			$(this).select();
			return false;
		});
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
		$(window).scroll(function(){
			var top = $('html, body').scrollTop();
			if (top >= articleTop && top <= articleBottom) {
				if (!enabled) {
					enabled = true
				}
				var percentageFinished = Math.round((top - articleTop) / (articleBottom - articleTop - calculationPadding) * 100);
				line.width(percentageFinished + '%');
			} else {
				if (enabled) {
					line.width(0);
					enabled = false;
				}
			}
		})
	});
});

// function to open urls in a new window (used for sharing)
function openWindow(url, title) {
	window.open(
		url, // url
		title, // window name
		'height=450,width=700,left=50,top=50'
	);
}