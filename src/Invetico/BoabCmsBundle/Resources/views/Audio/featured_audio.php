<h2>Featured Sermon</h2>
<div id="featured-audio" style="background-image:url()">
	<div class="img-container">
		<img src="<?php echo $this->content->getThumbnailUrlPath();?>" />
		<h3 class="audio-title"><?php echo $this->content->getTitle();?></h3>
	</div>
	<div class="bottom">
		<span class="audio-date"><i class="fa fa-calendar"></i><?php echo $this->content->getDatePublished();?></span>
		<a class="btn btn-black btn-sm" href="<?php echo $this->generate($this->content);?>">View Details</a>
		<div class="clear"></div>
	</div>
</div>