
<div class="page-container">
	<header class="page-heading">
		<h1 class="heading"><?php echo $this->content->getTitle();?></h1>
		<div class="meta-data">
			<span><label>Date Published:</label><?php echo $this->content->getDatePublished();?></span>, 
			<span><label>Published by:</label><?php echo $this->content->getAuthoredBy();?></span>
		</div>		
	</header>
	
	<?php if($this->content->getThumbnailUrlPath()):?>
		<figure class="page-thumbnail audio-thumbnail">
			<img class="img-responsive" src="[asset path=<?php echo $this->content->getThumbnailUrlPath();?>]" alt="<?php echo $this->content->getTitle();?>">
		</figure>
	<?php endif;?>	
	
	<article class="page-body">
		<div class="audio-player-container">
			<div id="audio-player">Loading the player...</div>
				<script type="text/javascript">
				$(document).ready(function () {
					var playerInstance = jwplayer("audio-player");
					playerInstance.setup({
						file: "[asset path=<?php echo $this->content->getAudioUrlPath();?>]",
						width: "100%",
						height: 40,
						//aspectratio: "16:9",
						title: "<?php echo $this->content->getTitle();?>",						
					});
				});
			</script>
		</div>


		<?php echo $this->content->getBody();?>

	</article>
</div>
	
<div class="comment-box">
	[commentbox id=comment]
</div>