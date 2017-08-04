
<div class="block">
	<div id="sidebar-video-widget">
		<h2>Other Videos</h2>
		<?php foreach($this->collection as $content):?>
		<article>
			<a href="<?php echo $this->generate($content);?>">
				<div class="img-box">
					<img src="<?php echo $content->getThumbnailUrlPath();?>" />
					<span>Posted on: <strong><?php echo $content->getDatePublished();?></strong></span>
					<div class="item-inner-bg"><h3><?php echo $content->getTitle();?></h3></div>
					<span class="player-btn"></span>
				</div>
			</a>
		</article>
		<?php endforeach;?>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>
