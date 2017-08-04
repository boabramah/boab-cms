            	

            	<?php foreach($this->collection as $content):?>
            		<div class="col-md-4 col-sermon">
	            		<article class="sermon-item">
	            			<a href="<?php echo $this->generate($content, 'audio_show');?>">
		            			<div class="img-container">
		            				<img src="<?php echo $content->getThumbnailUrlPath();?>" alt="<?php echo $content->getTitle();?>" />
		            				<div class="img-cover"></div>
		            				<h3><?php echo $content->getTitle();?></h3>
		            			</div>
		            			<div class="sermon-detail">
		            				<span class="sermon-date"><label>Date Published: </label><?php echo $content->getDatePublished();?></span>
		            				<p><?php echo word_limiter($content->getSummary(),200);?></p>
		            				 <span class="play-btn"> Play <i class="fa fa-play-circle-o"></i> Now</span>
		            			</div>
	            			</a>
	            		</article>
            		</div>
            	<?php endforeach;?>