

<?php foreach($this->collection as $content):?> 
<div class="col-sm-6 col-lg-3 col-md-3  ">
	<div class="ts-wrapper">
		<div class="team-item team-item-style1 text-center  ">
			<figure>
				<img src="[asset path=<?php echo $content->getDefaultThumbnail(); ?>]" alt="<?php echo $content->getTitle();?>">
				<ul class="social-network list-inline social-network-team">
					<li><a target="_blank" title="Kate Howston" href="#"><i class="fa fa-facebook"></i></a></li>
					<li><a target="_blank" title="Kate Howston" href="#"><i class="fa fa-youtube"></i></a></li>
					<li><a target="_blank" title="Kate Howston" href="#"><i class="fa fa-google-plus"></i></a></li>
					<li><a target="_blank" title="Kate Howston" href="#"><i class="fa fa-behance"></i></a></li>
				</ul>
			</figure>
			<h4><?php echo $content->getTitle();?></h4>
			<span><?php echo $content->getStaffPosition();?></span>
		</div>
	</div>
</div>
<?php endforeach;?>                         
