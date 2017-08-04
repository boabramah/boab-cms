
		<?php foreach($this->collection as $content):?>
                <div class="services-item column featured-style-one col-md-4 col-xs-12">
                    <div class="inner-box">
                        <figure class="image-box">
                        	<a href="#"><img src="[asset path=<?php echo $content->getThumbnailUrlPath();?>]" alt="<?php echo $content->getTitle();?>"></a>
                        </figure>
                        <div class="lower-content">
                            <h3><a href="#"><?php echo $content->getTitle();?></a></h3>
                            <div class="text"><?php echo word_limiter($content->getSummary(),200);?></div>
                            <a href="#" class="read-more">Learn More <span class="icon flaticon-arrows-1"></span></a>
                        </div>
                    </div>
                </div>			
		<?php endforeach;?>

