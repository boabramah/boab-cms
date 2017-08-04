						<div>
							<label>Location</label>
							<div id="location-input">
								<span class="input-wrapper">
										<select id="location-state" name="location_state" data-location-target="location-city" class="location-select">
											<option value="0"> - - Select your state - - </option>
											<?php echo $this->locationState; ?>
										</select>
										<?php echo $this->flash->getError('location_state',true);?>
								</span>
								<span class="input-wrapper">
										<select id="location-city" name="location_city" class="location-select">
											<option value="0"> - - Select your city or town - - </option>
											<?php echo $this->locationCity; ?>
										</select>
										<?php echo $this->flash->getError('location_state',true);?>
								</span>
								<br class="clear"/>
							</div>
						</div>
