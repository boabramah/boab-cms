[htmlwrap view='PageBundle:Block:page_header']
        <img src="<?php echo BASE_URL;?>theme/kantua/images/bg.jpg" />
        <div id="page-header-text" class="header-align-left">
        	<h1 class="text-big">Our Videos</h1>
        	<p class="big-paragraph">Explore our blog for impactful resources, insightful articles, and ideas that inspire action on the topics you care about</p>
        </div>
[/htmlwrap]


<section id="video-list-wrapper" class="outer-container">
	<div class="container">
		<div class="row big-padding">
			<?php foreach($this->collection as $content): ?>
				<div class="col-sm-3 col-md-3 col-lg-3 nopadding">
					<div class="video-wrapper">
						<a href="<?php echo $this->generate($content);?>">
							<div class="inner-container">
								<div class="img-wrapper">
									<img class="img-responsive" src="[asset path=<?php echo $content->getThumbnailUrlPath();?>]">
									<span class="date-published"><?php echo $content->getDatePublished();?></span>
									<span class="btn-play"><i class="fa fa-play"></i></span>
								</div>
								<div class="video-description">
									<h3><?php echo $content->getTitle();?></h3>
								</div>
							</div>
						</a>
					</div>
				</div>
			<?php endforeach;?>
		</div>
		<div id="pagination">
			<div class="inner">
				<?php echo $this->pagination;?>
			</div>
		</div>		
	</div>
</section>

