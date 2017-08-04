	
				<form method="post" action="<?php echo $this->action;?>" enctype="multipart/form-data">
					
					<div class="tabsContainer">
						<?php echo $this->partial('BoabCmsBundle:Admin:form_controls',['tabControls'=>function(){
							return '<li><a class="tab" role="tab" data-toggle="tab" id="album-photo-add" data-tab="admin-album-pictures" href="#admin-album-pictures">Upload Images</a></li>';
						}]);?>
						<?php require_once $this->fetch('BoabCmsBundle:Admin:form_controls');?>

						<div id="form-container">
							<input type="hidden" name="post_type" value="create" />

							<div id="main-setting" class="form-column-container active">

								<div class="form-group">
									<label>Title: <?php echo $this->flash->getError('page_title',true);?></label>
									<input class="form-control" id="page_title" name="page_title" type="text" value="<?php echo ($this->content->getTitle()) ? $this->content->getTitle() : $this->flash->getData('page_title'); ?>" />
								</div>

								<div class="form-group">
									<label>Summary:</label>
									<textarea class="form-control" name="page_summary" ><?php echo ($this->content->getSummary()) ? $this->content->getSummary() : $this->flash->getData('page_summary');  ?></textarea>
									<?php echo $this->flash->getError('page_summary',true);?>
								</div>

								<div class="form-group">
									<label>Body:</label>
									<textarea class="form-control content-editable" id="editor-fullxx" name="page_body" >
										<?php echo ($this->content->getBody()) ? $this->content->getBody() : $this->flash->getData('page_body');  ?>
									</textarea>
									<?php echo $this->flash->getError('page_body',true);?>
								</div>

								<?php include $this->fetch('BoabCmsBundle:Admin:thumbnail');?>

								<div class="clear"></div>
							</div>

							<div id="menu-setting" class="form-column-container">
								<div id="activate-menu" class="checkbox custom-checkbox">
									<label>
										<input type="checkbox" id="menu_enable" name="menu_enable" class="input-extra-settings" data-setting-target="menu-setting-box" <?php echo ($this->flash->getData('menu_enable') or $this->content->hasRoute())?'checked':'';?> />
										<span class="fa fa-check"></span>Provide Menu for content
									</label>
								</div>
								<div id="menu-setting-box" class="<?php echo (!$this->content->hasRoute()) ? 'slide-up' : 'slide-down'?>">
									<?php require_once $this->fetch('BoabCmsBundle:Admin:content_menu_option');?>
									<br class="clear" />
								</div>
								<div class="clear"></div>
							</div>

							<div id="seo-setting" class="form-column-container">
								<div class="form-group">
									<label>Meta Keywords: <?php echo $this->flash->getError('meta_keywords',true);?></label>
									<input class="form-control" id="meta_keywords" name="meta_keywords" type="text" value="<?php echo ($this->content->getMetaKeyWords()) ? $this->content->getMetaKeyWords() : $this->flash->getData('meta_keywords'); ?>" />
								</div>
								<div class="form-group">
									<label>Meta Description: <?php echo $this->flash->getError('meta_description',true);?></label>
									<input class="form-control" id="meta_description" name="meta_description" type="text" value="<?php echo ($this->content->getMetaDescription()) ? $this->content->getMetaDescription() : $this->flash->getData('meta_description'); ?>" />
								</div>								
							</div>

							<div id="other-setting" class="form-column-container">
								<?php require_once $this->fetch('BoabCmsBundle:Admin:edit_content_other_settings');?>
							</div>

							<div id="admin-album-pictures" class="form-column-container">
								<?php echo $this->albumPhotos;?>
								<div class="btn-add-image">
									<a  class="add-photo" data-album-id="<?php echo $this->content->getId();?>" href="<?php echo $this->photoUploadUrl;?>">Add Image</a>
								</div>
							</div>							
							
						</div>
						<div class="submit-box">
							<button class="btn btn-green isThemeBtn" id="submit">submit</button>
						</div>

					</div>

				</form>
				<?php require_once $this->fetch('BoabCmsBundle:Script:photo_entry.js');?>
				<?php require_once $this->fetch('BoabCmsBundle:Script:photo_wrapper_tpl.js');?>
				<?php require_once $this->fetch('BoabCmsBundle:Script:progress_bar_tpl.js');?>				
