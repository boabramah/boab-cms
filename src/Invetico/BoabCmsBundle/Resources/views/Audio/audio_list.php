  [htmlwrap view=BoabCmsBundle:Block:page_header]
    <ol class="breadcrumb">
      <li><a href="[link route_name=site_root]">Home</a></li>
      <li class="active">Sermons</li>
    </ol>
  [/htmlwrap]



<div id="sermons-section" class="main pad100">
    <div class="inner-container overlay-light">
        <div class="container">
            <header class="section-header">
              <h2><?php echo $this->routeDocument->getTitle();?></h2>
              <p>Explore our weekly sermons for impactful and insightful <br> Word of God that will change your life forever.</p>
            </header>

          <div class="row">
            	<?php foreach($this->collection as $content):?>
            		<div class="col-md-3">
	            		<article class="sermon-item">
	            			<a href="<?php echo $this->generate($content);?>">
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
          </div>
    	  </div>
        <div class="container">
      		<div id="pagination" class="text-center">
      			<div class="inner">
      				<?php echo $this->pagination;?>
      			</div>
      		</div> 
        </div>   	
  	</div>
</div>

