
 <div class="row">          
    <?php foreach($this->collection as $content):?>
    <div class="col-md-6 article">
	    <div>
	    	<div class="row col">
	    		<div class="col-md-6">
			    	<div class="img-wrapper">
						<img class="img-responsive" src="[asset path=<?php echo $content->getThumbnailUrlPath();?>]" />
			    	</div>
			    </div>
			    <div class="col-md-6">
					<div class="description">
						<h3><a href="<?php echo $this->generate($content);?>"><?php echo $content->getTitle();?></a></h3>
						<span><i class="fa fa-user"></i><small> by <?php echo $content->getAuthoredBy();?></small></span>
						<div>
							<span><i class="fa fa-clock-o"></i> <?php echo $content->getDatePublished();?></span>
							<span></span>
						</div>
	        		</div>
	        	</div>
	        </div>
	    </div>             
    </div>             
    <?php endforeach;?> 
</div>           

