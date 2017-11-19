var keys = {
	escape: 27,
	space: 32,
	left: 37,
	up: 38,
	right: 39,
	down: 40,
	f: 70
};

function changeFillWindowState(state) {
	var underlay = $('.underlay');
	var video = $('video');
	if (!state) {
		underlay.css({
			'display': 'block',
			'position': 'absolute',
			'left': '0',
			'top': '0',
			'width': $(window).width(), 
			'height': $(window).height()
		});
		video.css({
			'position': 'absolute',
			'left': '0',
			'top': '0',
			'width': $(window).width(), 
			'height': $(window).height()
		});
		$('.navbar').css({
			'display': 'none'
		});
		state = true;
	} else {
		underlay.removeAttr('style');
		video.removeAttr('style');
		$('.navbar').removeAttr('style');
		state = false;
	}
	return state;
}

$(document).ready(function() {
	var video = $('video');
	var currentVideo = video[0];
	var windowScreen = false;
	$(document).keyup(function(e) {
		if (e.keyCode == keys.space) {
			if (currentVideo.paused) {
				currentVideo.play();
			} else {
				currentVideo.pause();
			}
		}
	});
	$(document).keydown(function(e) {
		switch(e.keyCode) {
			case keys.left:
				currentVideo.currentTime -= 5;
				break;
			case keys.up:
				currentVideo.volume += 0.05;
				break;
			case keys.right:
				currentVideo.currentTime += 5;
				break;
			case keys.down:
				currentVideo.volume -= 0.05;
				break;
			case keys.escape:
				if (windowScreen) {
					windowScreen = changeFillWindowState(windowScreen);
				}
				break;
			case keys.f:
				windowScreen = changeFillWindowState(windowScreen);
				break;
		}
	});
	$(video).click(function() {
		if (currentVideo.paused) {
			currentVideo.play();
		} else {
			currentVideo.pause();
		}
	});
	$(video).dblclick(function() {
		windowScreen = changeFillWindowState(windowScreen);
	});
	var scrollPos = 0;
	var timer;
	checkCursorMovement = function() {
		video.css('cursor', 'none');
	}
	timer = setTimeout(checkCursorMovement, 2000);
	window.onmousemove = function() {
		clearTimeout(timer);
		video.css('cursor', 'auto')
		timer = setTimeout(checkCursorMovement, 2000);
	}

	/*var nextEpisode = $('.nextEpisode').attr("name");
	if (currentVideo.ready) {
		var nextvideo;
		var req = new XMLHttpRequest();
		req.open('GET', nextEpisode);
		var videoBlob = req.response;
		var vid = URL.createObjectURL(videoBlob);

		$('.nextEpisode').click(function() {
			console.log(nextvideo);
			currentVideo.src = vid;
		});
	}*/
});