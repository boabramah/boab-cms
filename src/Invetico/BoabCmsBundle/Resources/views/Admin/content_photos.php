
		<div class="row" id="admin-photo-container">
			<?php foreach($this->collection as $photo):?>
			<div class="col-md-3 photo-container">
				<div class="imageHolder" id="img-<?php echo $photo->getId();?>">
					<img src="<?php echo BASE_URL.$photo->getSmallThumbnailPath();?>">
					<span class="img-controls">
					    <a class="photo-view btn btn-success btn-xs" href="<?php echo BASE_URL . $photo->getLargeThumbnailPath();?>" rel="fancybox">View</a>
					    <a class="photo-delete btn btn-danger btn-xs" href="<?php echo $this->deletePhotoUrl($photo);?>">Delete</a>                        			
					</span>
				</div>
			</div>
			<?php endforeach;?>
		</div>