/*$(document).ready(function() {
	var currentVideo = $('video');
	var nextEpisode = $('.nextEpisode').attr("name");
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
	}
});*/