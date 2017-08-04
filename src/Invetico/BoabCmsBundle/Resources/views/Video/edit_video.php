
				<form class="form-style" method="post" action="<?php echo $this->action;?>" enctype="multipart/form-data">

					<?php require_once $this->fetch('BoabCmsBundle:Admin:form_controls');?>

					<div id="form-container">

						<input type="hidden" name="post_type" value="create" />

						<div id="main-setting" class="form-column-container active">

							<div>
								<label>Title: <?php echo $this->flash->getError('page_title',true);?></label>
								<input id="page_title" name="page_title" type="text"
								value="<?php echo ($this->content->getTitle()) ? $this->content->getTitle() : $this->flash->getData('page_title'); ?>" />
							</div>

							<div>
								<label>Summary:</label>
								<textarea class="desc" name="page_summary" ><?php echo ($this->content->getSummary()) ? $this->content->getSummary() : $this->flash->getData('page_summary');  ?></textarea>
								<?php echo $this->flash->getError('page_summary',true);?>
							</div>

							<div>
								<label>Body:</label>
								<textarea class="desc" id="editor-full" name="page_body" >
									<?php echo ($this->content->getBody()) ? $this->content->getBody() : $this->flash->getData('page_body');  ?>
								</textarea>
								<?php echo $this->flash->getError('page_body',true);?>
							</div>
							<div>
								<label>YouTube Video id: <?php echo $this->flash->getError('youtube_video_id',true);?></label>
								<input id="youtube_video_id" name="youtube_video_id" type="text" value="<?php echo $this->content->getYoutubeVideoId(); ?>" />
							</div>

							<?php include $this->fetch('BoabCmsBundle:Admin:taxonomy_term');?>

							<?php include $this->fetch('BoabCmsBundle:Admin:thumbnail');?>

							<div class="clear"></div>
						</div>

						<div id="menu-setting" class="form-column-container">
							<div id="activate-menu" class="checkbox-input">
								<span><input type="checkbox" id="menu_enable" name="menu_enable"

									<?php if($this->flash->getData('menu_enable') or $this->content->hasRoute()):
	                                echo 'checked';
	                                endif; ?> /></span>

								<span>Provide Menu for content:</span>
							</div>
							<div id="menu-setting-box" class="<?php echo (!$this->content->hasRoute()) ? 'slide-up' : 'slide-down'?>">
								<?php require_once $this->fetch('BoabCmsBundle:Admin:content_menu_option');?>
								<br class="clear" />
							</div>
							<div class="clear"></div>
						</div>

						<div id="other-setting" class="form-column-container">
							<?php require_once $this->fetch('BoabCmsBundle:Admin:edit_content_other_settings');?>
						</div>
							<br class="clear" />
					</div>
					<div class="submit-box">
						<button class="btn btn-green isThemeBtn" id="submit">submit</button>
					</div>					
				</form>
