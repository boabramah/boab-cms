
			<form  method="post" action="<?php echo $this->action;?>" enctype="multipart/form-data">
				<div class="tabsContainer">
				<?php include $this->fetch('BoabCmsBundle:Admin:form_controls');?>
					<div class="tab-content">
						<div id="form-container">
							<input type="hidden" name="post_type" value="create" />
							<div id="main-setting" class="form-column-container active">
								<div class="form-group">
									<label>Title: <?php echo $this->flash->getError('page_title',true);?></label>
									<input class="form-control" id="page_title" name="page_title" type="text" value="<?php echo $this->flash->getData('page_title'); ?>" />
								</div>
								<div class="form-group">
									<label>Summary:</label>
									<textarea class="form-control desc" name="page_summary" ><?php echo $this->flash->getData('page_summary');  ?></textarea>
									<?php echo $this->flash->getError('page_summary',true);?>
								</div>
								<div>
									<label>Body:</label>
									<textarea class="desc" id="editor-basic" name="page_body" ><?php echo $this->flash->getData('page_body');  ?></textarea>
									<?php echo $this->flash->getError('page_body',true);?>
								</div>

								<div class="form-group">
									<label>YouTube Video Id: </label>
									<input class="form-control" id="youtube_video_id" name="youtube_video_id" type="text" value="<?php echo $this->flash->getData('youtube_video_id'); ?>" />
									<?php echo $this->flash->getError('youtube_video_id',true);?>
								</div>

								<?php include $this->fetch('BoabCmsBundle:Admin:taxonomy_term');?>

								<?php include $this->fetch('BoabCmsBundle:Admin:thumbnail');?>

								<div class="clear"></div>
							</div>

							<div id="menu-setting" class="form-column-container">
								<div id="activate-menu" class="checkbox-input">
									<span><input type="checkbox" id="menu_enable" name="menu_enable" <?php echo (!$this->flash->getData("menu_enable")) ?: 'checked'; ?> /></span>
									<span>Provide Menu for content:</span>
								</div>

								<?php if (!$this->content->hasRoute()) {
		                            require_once $this->fetch('BoabCmsBundle:Admin:content_menu_option');
		                        };?>
								<div class="clear"></div>
							</div>

							<div id="other-setting" class="form-column-container">
								<?php require_once $this->fetch('BoabCmsBundle:Admin:add_content_other_settings');?>
							</div>
						</div>
						<div class="submit-box">
							<button class="btn btn-green isThemeBtn" id="submit">submit</button>
						</div>						
					</div>
				</div>
			</form>
