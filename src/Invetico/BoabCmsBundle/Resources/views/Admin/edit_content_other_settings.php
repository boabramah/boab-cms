                        
                        <?php if($this->pagesOptions):;?>
                            <?php include $this->fetch('BoabCmsBundle:Admin:pages_option_list');?>
                        <?php endif; ?>

                        <div class="form-group">
                            <label>Authored By:</label>
                            <input class="form-control" id="authored_by" name="authored_by" type="text" value="<?php echo $this->content->getAuthoredBy(); ?>" />
                            <span class="help-block">Leave blank for Anonymous.</span>
                        </div>

                        <div class="form-group">
                            <label>Status:</label>
                            <select id="page_status" name="page_status" class="input-select" style="width:300px;">
                                <?php echo statusOption($this->content->getStatus());?>
                            </select>
                            <?php echo $this->flash->getError('page_status',true);?>
                        </div>

                        <div class="form-group">
                            <label>Date Published:</label>
                            <input class="form-control" id="published_date" name="published_date" type="text" value="<?php echo $this->content->getDatePublished() ; ?>" />
                            <span class="help-block">Format: 2014-07-01 9:37:09. Leave blank to use the time of form submission.</span>
                        </div>

                        <div class="checkbox custom-checkbox">
                            <label>
                                <input type="checkbox" id="is_featured" name="is_featured"<?php echo $this->content->isFeatured() ? 'checked' : ''; ?> />
                                <span class="fa fa-check"></span>Make this content featured
                            </label>
                        </div>

                        <div class="checkbox custom-checkbox">
                            <label>
                                <input type="checkbox" id="content_promoted" name="content_promoted"<?php echo $this->content->isPromoted() ? 'checked' : ''; ?> />
                                <span class="fa fa-check"></span>Promote to front page
                            </label>
                        </div>

