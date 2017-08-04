						<div class="form-group">
							<label>Menu Link Title:</label>
							<input class="form-control" id="menu_title" name="menu_title" type="text" value="<?php echo !$this->content->hasRoute() ? '' : $this->content->getMenu()->getTitle(); ?>" />
							<span class="help-block">The text to be used for this link in the menu.</span>
							<?php echo $this->flash->getError('menu_title',true);?>
						</div>

						<div id="alias-box" class="form-group">
							<label>Path</label>
							<input class="form-control" type="text" name="menu_path" value="<?php echo $this->content->hasRoute() ? $this->content->getMenu()->getPath() : '';?>">
							<span class="help-block">Custom url to the page: leave blank to use default</span>
							<?php echo $this->flash->getError('menu_path',true);?>
						</div>

						<div class="form-group">
							<label>Template:</label>
							<input class="form-control" id="menu_page_template" name="menu_page_template" type="text" value="<?php echo $this->content->hasRoute() ? $this->content->getMenu()->getTemplate() : '';?>" />
							<span class="help-block">Template to use to render this page</span>
						</div>	

						<div class="form-group">
							<div class="radio custom-radio col-sm-2">
								<label>
									<input id="layout_type" name="layout_type" type="radio" value="1" <?php echo ($this->content->getLayoutType() == 1) ? 'checked' : ''; ?> />
									<span class="fa fa-circle"></span>One Column
								</label>
							</div>
							<div class="radio custom-radio custom-radio-last col-sm-10">
								<label>
									<input id="layout_type" name="layout_type" type="radio" value="2" <?php echo ($this->content->getLayoutType() == 2) ? 'checked' : ''; ?> />
									<span class="fa fa-circle"></span>Two Column
								</label>
							</div>
							<div class="clear"></div>
						</div>								

						<div class="form-group">
							<label>Parent:</label>
							<select name="menu_parent_id" id="menu_parent_id" class="input-select" style="300px">
								<option value="0"> -- Root -- </option>
								<?php echo $this->menuOptionList;?>
							</select>
							<span class="help-block">The maximum depth for a link and all its children is fixed at 9. Some menu links may not be available as parents if selecting them would exceed this limit.</span>
						</div>

						<div class="checkbox custom-checkbox">
							<label>
								<input type="checkbox" id="menu_visibility" name="menu_visibility"
								<?php if ($this->content->hasRoute()) {
                                    echo $this->content->getMenu()->getVisibility() ? 'checked' : '';
                                };?>
								/>
								<span class="fa fa-check"></span>Display link on public page
							</label>
						</div>
