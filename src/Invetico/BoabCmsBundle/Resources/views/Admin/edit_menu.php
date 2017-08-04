
			<div id="form-container">
					<form method="POST" action="<?php echo $this->action;?>" enctype="multipart/form-data">
						<div class="form-group">
							<label>Menu Link Title:</label>
							<input class="form-control" id="menu_title" name="menu_title" type="text" value="<?php echo ($this->flash->getData("title")) ? $this->flash->getData("title") : $this->menu->getTitle(); ?>" />
							<span class="help-block">The text to be used for this link in the menu.</span>
							<?php echo $this->flash->getError('menu_title',true);?>
						</div>

						<div id="alias-box" class="form-group">
							<label>Path</label>
							<input class="form-control" type="text" name="menu_path" value="<?php echo ($this->flash->getData('menu_path')) ? $this->flash->getData('menu_path') : $this->menu->getPath();?>">
							<span class="help-block">Custom url to the page: leave blank to use default</span>
							<?php echo $this->flash->getError('menu_path',true);?>
						</div>

						<div id="alias-box" class="form-group">
							<label>Custom Rout Name</label>
							<input class="form-control" type="text" name="route_name" value="<?php echo ($this->flash->getData('route_name')) ? $this->flash->getData('route_name') : $this->menu->getRouteName();?>">
							<span class="help-block">Custom route name</span>
							<?php echo $this->flash->getError('route_name',true);?>
						</div>	

						<div class="form-group">
							<label>Parent:</label>
							<select name="menu_parent_id" id="menu_parent_id" class="input-select">
								<option value="0"> -- Root -- </option>
								<?php echo $this->parentOption;?>
							</select>
							<span class="help-block">The maximum depth for a link and all its children is fixed at 9. Some menu links may not be available as parents if selecting them would exceed this limit.</span>
						</div>

						<div class="checkbox custom-checkbox">
							<label>
								<input type="checkbox" id="menu_visibility" name="menu_visibility" <?php echo !$this->menu->isVisible()?:'checked'; ?> />
								<span class="fa fa-check"></span>Display link on public page
							</label>
						</div>						

						<div class="checkbox custom-checkbox">
							<label>
								<input type="checkbox" id="extra_config" name="extra_config" <?php echo (!$this->menu->hasExtraConfig())?:'checked'; ?> />
								<span class="fa fa-check"></span>Enable additional configuration
							</label>
						</div>	

						<?php if($this->menu->hasExtraConfig()):?>

						<div id="alias-box" class="form-group">
							<label>Controller</label>
							<input class="form-control" type="text" name="controller_name" value="<?php echo ($this->flash->getData('controller_name')) ? $this->flash->getData('controller_name') : $this->menu->getController()?>"
							<span class="desc">Custom controller name</span>
							<?php echo $this->flash->getError('controller_name',true);?>
						</div>

						<div id="alias-box" class="form-group">
							<label>Template</label>
							<input class="form-control" type="text" name="menu_page_template" value="<?php echo ($this->flash->getData('menu_page_template')) ? $this->flash->getData('menu_page_template') : $this->menu->getTemplate()?>">
							<span class="desc">Template</span>
							<?php echo $this->flash->getError('menu_page_template',true);?>
						</div>						

						<div id="alias-box" class="form-group">
							<label>Content type</label>
							<input class="form-control" type="text" name="content_type" value="<?php echo ($this->flash->getData('content_type')) ? $this->flash->getData('content_type') : $this->menu->getContentType()?>"
							<span class="desc">Content type</span>
							<?php echo $this->flash->getError('content_type',true);?>
						</div>	

						<?php endif;?>

						<button class="btn btn-green isThemeBtn" id="submit">submit</button>

					</form>
				</div>