								<div id="seo-setting" class="form-column-container">
									<div class="form-group">
										<label>Meta Keywords: <?php echo $this->flash->getError('meta_keywords',true);?></label>
										<input class="form-control" id="meta_keywords" name="meta_keywords" type="text" value="<?php echo ($this->content->getMetaKeyWords()) ? $this->content->getMetaKeyWords() : $this->flash->getData('meta_keywords'); ?>" />
									</div>
									<div class="form-group">
										<label>Meta Description: <?php echo $this->flash->getError('meta_description',true);?></label>
										<input class="form-control" id="meta_description" name="meta_description" type="text" value="<?php echo ($this->content->getMetaDescription()) ? $this->content->getMetaDescription() : $this->flash->getData('meta_description'); ?>" />
									</div>								
								</div>	