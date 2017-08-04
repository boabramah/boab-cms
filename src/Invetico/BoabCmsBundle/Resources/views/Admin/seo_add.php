							<div id="seo-setting" class="form-column-container">							
								<div class="form-group">
									<label>Meta Keywords: </label>
									<input class="form-control" id="meta_keywords" name="meta_keywords" type="text" value="<?php echo $this->flash->getData('meta_keywords'); ?>" />
									<?php echo $this->flash->getError('meta_keywords',true);?>
								</div>
								<div class="form-group">
									<label>Meta Description: </label>
									<input class="form-control" id="meta_description" name="meta_description" type="text" value="<?php echo $this->flash->getData('meta_description'); ?>" />
									<?php echo $this->flash->getError('meta_description',true);?>
								</div>								
							</div>