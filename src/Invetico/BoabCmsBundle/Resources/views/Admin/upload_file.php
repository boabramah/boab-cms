					<form id="thumbnail-upload-form" action="<?php echo $this->imageUploadUrl;?>" method="POST" enctype="multipart/form-data">
						<fieldset id="content-images-box">
							<legend>Images uploaded for content</legend>
							<div id="uploadedFilesBox">
								<div id="controls">
									<div id="control-wrapper">
										<input type="file" name="thumbnails[]" id="upload-file-input" multiple=""/>
										<a data-upload-area="upoaded-files-area" data-file-input="upload-file-input" href="#" style="display:inline-block" id="browse-btn">Choose file</a>
										<br />
										<span class="desc">Maximum of 6 photos allow. Hold ctrl or shift key to selecte multiple photos</span>
										<div class="clear"></div>
									</div>
									<div class="clear"></div>
								</div>
								<div id="upoaded-files-area">

								<?php //echo count($this->thumbnails);?>



								<?php foreach($this->thumbnails as $thumbnail):?>
					        		<div class="imgSelectPreview">
		                        		<span class="imageHolder">
		                            		<img src="<?php echo $thumbnail;?>"/>
		                            		<span class="img-controls trans">
		                            			<a class="thumbmail-view" href="<?php echo $thumbnail;?>" rel="lightbox">View</a>
		                            			<a class="thumbmail-set-cover" id="setListingCover" href="<?php echo $this->setCoverLink($thumbnail);?>">Set Cover</a>
		                            			<a class="thumbmail-delete" href="<?php echo $this->imageDeleteLink($thumbnail);?>">Delete</a>
		                            		</span>
		                        		</span>
		                    		</div>
		                    	<?php endforeach;?>

								</div>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
						</fieldset>
					</form>
