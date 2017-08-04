<div id="sermons-sidebar">
	<?php foreach($this->collection as $content):?>
		<a href="<?php echo $this->generate($content);?>">
			<div class="sermon">
				<div class="thumbnail-cover">
					<img src="<?php echo $content->getThumbnailUrlPath();?>">
				</div>
				<span>Posted on: <strong><?php echo $content->getDatePublished();?></strong></span>
				<h3 class="title"><?php echo $content->getTitle();?></h3>
			</div>
			<div class="clear"></div>
		</a>
	<?php endforeach;?>
	<div class="clear"></div>
</div>