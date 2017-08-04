						<?php if($this->taxonomyList):?>
						<div class="form-group">
							<label>Category:</label>
							<select class="input-select" id="content_category" name="content_category" class="selectBox" style="width:200px;">
								<option value="0">- - SELECT - -</option>
								<?php echo $this->taxonomyList;?>
							</select>
							<?php echo $this->flash->getError('content_category',true);?>
						</div>
						<?php endif;?>
