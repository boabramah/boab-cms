<div id="featured-article">
	<div class="img-box"><img src="<?php echo $this->content->getThumbnailUrlPath();?>"></div>
	<h2><?php echo $this->content->getTitle();?></h2>	
	<span><i class="fa fa-user"></i><?php echo $this->content->getAuthoredBy();?></span>
	<div class="article-d-u">
		<span><i class="fa fa-clock-o"></i><?php echo $this->content->getDatePublished('d-m-Y');?></span>
	</div>
	<p><?php echo word_limiter($this->content->getSummary(),300);?></p>
	<a class="btn btn-default btn-lg btn-site-2" href="<?php echo $this->generate($this->content);?>">View Details</a>
</div>


