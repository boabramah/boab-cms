						<div class="form-group">
							<label>Parent:</label>
							<select id="page_parent" name="page_parent" class="input-select" style="width:300px;">
								<option value="0">--- No parent ---</option>
								<?php echo $this->pagesOptions; ?>
							</select>
							<?php echo $this->flash->getError('page_parent',true);?>
						</div>
