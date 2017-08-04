<div id="member-profile">
	<div class="div-height ">
		<div class="avatar-container">
			<div class="circle-avatar" style="background-image:url([asset path=<?php echo $this->content->getDefaultThumbnail()  ;?>)]"></div>
		</div>
	</div>
	<div class="title-position">
		<h1 class="title"><?php echo $this->content->getTitle();?></h1>
		<span class="position"><?php echo $this->content->getStaffPosition();?></span>
	</div>
	<div class="body"><?php echo $this->content->getBody();?></div>
</div>




