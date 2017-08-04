


        <script type="text/x-handlebars" id="profile-thumbnail-tpl">
            <div class="modal fade" id="thumbnail-upload" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    	<form id="thumbnailUploadForm" action="{{action}}" method="POST" enctype="multipart/form-data">
	                        <div class="modal-header">
	                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
	                            <h4 class="modal-title custom_align" id="Heading">Change Profile Picture</h4>
	                        </div>
	                        <div class="modal-body">							
								<div id="profile-thumbnail-box">
									<div id="profile-thumbnail" style="">
										<div class="clear"></div>
									</div>
									{{{progressBar}}}
									<div class="clear"></div>
								</div>
								<br>	
								<input type="file" name="thumbnail" id="profile-thumbnail-loaded" style="display:none">
								
								<div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>
	                        </div>
	                        <div class="modal-footer ">
	                            <button id="change-thumbnail" type="button" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span>Choose Photo</button>	                            
	                        </div>
	                    </form>
                    </div>
                </div> 
            </div>       
        </script>
