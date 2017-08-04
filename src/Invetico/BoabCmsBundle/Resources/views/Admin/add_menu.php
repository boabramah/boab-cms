
			<div id="form-container">
					<form method="POST" action="<?php echo $this->action;?>" enctype="multipart/form-data">
						
						<?php require_once $this->fetch('BoabCmsBundle:Admin:add_menu_detail');?>
						
						<div class="checkbox custom-checkbox">
							<label>
								<input type="checkbox" id="extra_config" name="extra_config" class="input-extra-settings" data-setting-target="menu-extra-settings" <?php echo (!$this->flash->getData("extra_config"))?:'checked'; ?> />
								<span class="fa fa-check"></span>Enable additional configuration
							</label>
						</div>

						<?php require_once $this->fetch('BoabCmsBundle:Admin:menu_extra_settings');?>

						<button class="btn btn-green isThemeBtn" id="submit">submit</button>
					</form>
				</div>

