		<div id="menu-extra-settings" class="slide-up">
			<div id="alias-box" class="form-group">
				<label>Controller</label>
				<input class="form-control" type="text" name="controller_name" value="<?php echo $this->flash->getData('controller_name');?>">
				<span class="help-block">Custom controller name</span>
				<?php echo $this->flash->getError('controller_name',true);?>
			</div>

			<div id="alias-box" class="form-group">
				<label>Content type</label>
				<input class="form-control" type="text" name="content_type" value="<?php echo $this->flash->getData('content_type');?>">
				<span class="help-block">Content type</span>
				<?php echo $this->flash->getError('content_type',true);?>
			</div>	
			<div class="clear"></div>
		</div>