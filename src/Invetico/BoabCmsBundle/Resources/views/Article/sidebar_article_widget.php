
                <div class="recentPosts sidebarWidget">
                    <?php foreach($this->collection as $content):?>
                        <div class="col-sm-6 item col-md-6 col-lg-12">
                            <div class="img-box"><img class="img-responsive" src="[asset path=<?php echo $content->getThumbnailUrlPath();?>]"></div>
                            <h4><a href="<?php echo $this->generate($content);?>"><?php echo $content->getTitle();?></a></h4>
                            <span class="date">Feb 5, 2014</span>
                        </div>
                    <?php endforeach;?>
                </div>

