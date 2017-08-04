			<?php foreach($this->collection as $content): ?>
				<div class="col-sm-3 col-md-3 col-lg-3 nopadding">
					<div class="video-wrapper">
						<a href="<?php echo $this->generate($content);?>">
							<div class="inner-container">
								<div class="img-wrapper">
									<img class="img-responsive" src="[asset path=<?php echo $content->getThumbnailUrlPath();?>]">
									<span class="date-published"><?php echo $content->getDatePublished();?></span>
									<span class="btn-play"><i class="fa fa-play"></i></span>
								</div>
								<div class="video-description">
									<h3><?php echo $content->getTitle();?></h3>
								</div>
							</div>
						</a>
					</div>
				</div>
			<?php endforeach;?>