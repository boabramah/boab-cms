<div id="player-area">
	<div id="player-box">
	<div data-video-url="<?php echo $this->content->getVideoUrl();?>" data-video-thumb="<?php echo $this->content->getThumbnailUrlPath();?>" id="videoPlayer" >Loading the player...</div>
		<script type="text/javascript">
		$(document).ready(function () {
			var url = $('#videoPlayer').data("video-url");
			var thumb = $('#videoPlayer').data("video-thumb");
			console.log(url);
			jwplayer("videoPlayer").setup({
				file: url,
				image: thumb,
				aspectratio: "16:9",
				width: "100%"
			});
		   });
		</script>
	</div>
	<div class="clear"></div>
</div>
