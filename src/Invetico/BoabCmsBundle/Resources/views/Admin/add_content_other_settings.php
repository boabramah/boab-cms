						<?php if($this->pagesOptions):;?>
							<?php include $this->fetch('BoabCmsBundle:Admin:pages_option_list');?>
						<?php endif; ?>

						<div class="form-group">
							<label>Authored By:</label>
							<input class="form-control" id="authored_by" name="authored_by" type="text" value="<?php echo $this->flash->getData('authored_by'); ?>" />
							<span class="desc">Leave blank for Anonymous.</span>
						</div>

						<div class="form-group">
							<label>Page status:</label>
							<select id="page_status" name="page_status" class="input-select" style="width:200px;">
								<?php echo statusOption($this->flash->getData('page_status'));?>
							</select>
							<?php echo $this->flash->getError('page_status',true);?>
						</div>

						<div class="form-group">
							<label>Date Published:</label>
							<input class="form-control" id="published_date" name="published_date" type="text" value="<?php echo $this->flash->getData('published_date'); ?>" />
							<span class="desc">Format: 2014-07-01 9:37:09. Leave blank to use the time of form submission.</span>
						</div>

						<div class="checkbox custom-checkbox">
							<label>
								<input  type="checkbox" id="is_featured" name="is_featured"<?php echo $this->flash->getData('is_featured') ? 'checked' : ''; ?> />
								<span class="fa fa-check"></span>Make this content featured
							</label>
						</div>

						<div class="checkbox custom-checkbox">
							<label>
								<input type="checkbox" id="content_promoted" name="content_promoted"<?php echo $this->flash->getData('content_promoted') ? 'checked' : ''; ?> />
								<span class="fa fa-check"></span>Promote to front page
							</label>
						</div>

						
