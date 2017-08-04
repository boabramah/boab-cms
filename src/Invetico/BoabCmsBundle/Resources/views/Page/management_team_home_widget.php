
                <?php foreach($this->collection as $content):?>
                        <div class="col-md-3">
                            <div class="profile_pic">
                                <figure class="pic-hover hover-scale mb30">
                                    <img src="[asset path=<?php echo $content->getDefaultThumbnail(); ?>]" class="img-responsive" alt="<?php echo $content->getTitle();?>">
                                </figure>

                                <h3><?php echo $content->getTitle();?></h3>
                                <span class="subtitle"><?php echo $content->getStaffPosition();?></span>
                                <span class="tiny-border"></span>
                            </div>
                        </div>               
                <?php endforeach;?>
 