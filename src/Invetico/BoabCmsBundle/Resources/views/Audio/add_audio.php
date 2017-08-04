
			<form class="form-style" method="post" action="<?php echo $this->action;?>" enctype="multipart/form-data">
				<div class="tabsContainer">
					<?php require_once $this->fetch('BoabCmsBundle:Admin:form_controls');?>
					
					<div id="form-container">		
						<input type="hidden" name="post_type" value="create" />
						<div id="main-setting" class="form-column-container active">
							<div>
								<label>Title: <?php echo $this->flash->getError('page_title',true);?></label>
								<input id="page_title" name="page_title" type="text" value="<?php echo $this->flash->getData('page_title'); ?>" />
							</div>
							<div class="form-group">
								<label>Summary:</label>
								<textarea class="form-control desc" name="page_summary" ><?php echo $this->flash->getData('page_summary');  ?></textarea>
								<?php echo $this->flash->getError('page_summary',true);?>
							</div>							
							<div>
								<label>Body:</label>
								<textarea class="desc" id="editor-full" name="page_body" ><?php echo $this->flash->getData('page_body');  ?></textarea> 
								<?php echo $this->flash->getError('page_body',true);?>
							</div>

							<div>
								<label>Author: <?php echo $this->flash->getError('audio_author',true);?></label>
								<input id="audio_author" name="audio_author" type="text" value="<?php echo $this->flash->getData('audio_author'); ?>" />
							</div>

							<div>
								<label>Audio File:</label>
								<input type="file" name="audio_file" id="audio_file" />
								<span class="desc">Allowed audio files: mp3.</span>
							</div>

							<div>
								<label>Thumbnail(272px X 131px):</label>
								<input type="file" name="thumbnail" id="thumbnail">
								<span class="desc">One file only. 128 MB limit. Allowed types: png gif jpg jpeg.</span>
							</div>
							<div class="clear"></div>	
						</div>

						<div id="menu-setting" class="form-column-container">
							<div id="activate-menu" class="checkbox-input">
								<span><input type="checkbox" id="menu_enable" name="menu_enable" <?php echo (!$this->flash->getData("menu_enable"))?:'checked'; ?> /></span>
								<span>Provide Menu for content:</span>
							</div>

							<?php if(!$this->content->hasRoute()){
								require_once $this->fetch('BoabCmsBundle:Admin:content_menu_option');
							};?>
							<div class="clear"></div>
						</div>

						<div id="other-setting" class="form-column-container">
							<?php require_once $this->fetch('BoabCmsBundle:Admin:add_content_other_settings');?>
						</div>
						<br class="clear" />
					</div>
					<div class="submit-box">
						<button class="btn btn-green isThemeBtn" id="submit">submit</button>
					</div>					
				</div>
			</form>


 


