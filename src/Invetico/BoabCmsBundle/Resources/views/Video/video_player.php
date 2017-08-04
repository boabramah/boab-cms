<div class="page-container">
	<header class="page-heading">
		<h1 class="heading"><?php echo $this->content->getTitle();?></h1>
		<div class="meta-data">
			<span><label>Date Published:</label><?php echo $this->content->getDatePublished();?></span>, 
			<span><label>Published by:</label><?php echo $this->content->getAuthoredBy();?></span>
		</div>		
	</header>
	<article class="page-body">
		<div class="video-player-container">
			<div id="videoPlayer"
				data-video-url="<?php echo $this->content->getVideoUrl();?>" 
				data-video-thumb="[asset path=<?php echo $this->content->getThumbnailUrlPath();?>]" >
				 Loading the player...
			</div>
			<script type="text/javascript">
				$(document).ready(function () {
					var url = $('#videoPlayer').data("video-url");
					var thumb = $('#videoPlayer').data("video-thumb");
					//console.log(thumb);
					//console.log(url);
					var player = jwplayer("videoPlayer");
					player.setup({
						file: url,
						title: "<?php echo $this->content->getTitle();?>",
						image: thumb,
						aspectratio: "16:9",
						width: "100%",
						height:"500px",
						mediaid: "5lK6iCm",
						//autostart: true,
					});

					$(".video-player-container").mouseenter(function() {
						player.setControls(true);
					}).mouseleave(function () {
						player.setControls(false);
					});					

					//console.log(player.getProvider());
				});
			</script>
		</div>
		<div class="video-description">
			<?php echo $this->content->getBody();?>
		</div>
	</article>
</div>

<div class="comment-box">
    [commentbox id=comment]
</div>