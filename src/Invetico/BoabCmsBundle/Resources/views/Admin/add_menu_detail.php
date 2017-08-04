						<div class="form-group">
							<label>Menu Link Title:</label>
							<input class="form-control" id="menu_title" name="menu_title" type="text" value="<?php echo $this->flash->getData("title"); ?>" />
							<span class="help-block">The text to be used for this link in the menu.</span>
							<?php echo $this->flash->getError('menu_title',true);?>
						</div>

						<div class="form-group" >
							<label>Path</label>
							<input class="form-control" type="text" name="menu_path" value="<?php echo $this->flash->getData('menu_path');?>">
							<span class="help-block">Custom url to the page: leave blank to use default</span>
							<?php echo $this->flash->getError('menu_path',true);?>
						</div>	

						<div class="form-group" >
							<label>Custom Rout Name</label>
							<input class="form-control" type="text" name="route_name" value="<?php echo $this->flash->getData('route_name');?>">
							<span class="help-block">Custom route name</span>
							<?php echo $this->flash->getError('route_name',true);?>
						</div>												

						<div class="form-group">
							<label>Parent:</label>
							<select name="menu_parent_id" id="menu_parent_id" class="input-select" style="300px">
								<option value="0"> -- Root -- </option>
								<?php echo $this->parentOption;?>
							</select>
							<span class="help-block">The maximum depth for a link and all its children is fixed at 9. Some menu links may not be available as parents if selecting them would exceed this limit.</span>
						</div>

						<div class="checkbox custom-checkbox">
							<label>
								<input type="checkbox" id="menu_visibility" name="menu_visibility" <?php echo (!$this->flash->getData("menu_visibility"))?:'checked'; ?> />
								<span class="fa fa-check"></span>Display link on public page
							</label>
							
						</div>

																