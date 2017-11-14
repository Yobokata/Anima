var keys = {
	escape: 27,
	space: 32,
	left: 37,
	up: 38,
	right: 39,
	down: 40
};

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
				video.removeAttr('style');
				windowScreen = false;
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
		if (!windowScreen) {
			video.css({
				'position': 'absolute',
				'left': '0',
				'top': $('.navbar').height(),
				'width': '100vw', 
				'height': $(window).height() - $('.navbar').height()
			});
			windowScreen = true;
		} else {
			video.removeAttr('style');
			windowScreen = false;
		}
	});
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