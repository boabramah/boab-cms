
<div id="content-types-container">
	<?php foreach($this->contentTypes as $contentType):?>
	<div class="content-type">
		<a href="<?php echo $this->generateTypeUrl($contentType);?>">
			<h3><?php echo ucfirst($contentType->getEntity()->getContentTypeLabel());?></h3>
			<span><?php echo $contentType->getContentTypeDescription();?></span>
		</a>
	</div>
	<?php endforeach;?>
</div>
