<div id="top-toolbar">
	<ul>
		<li><a>Welcome <?php echo $this->user->getLastName();?></a> |</li> 
		<li><a href="<?php echo $this->generateLink('user_settings_profile');?>">Profile</a> |</li>
		<li><a href="<?php echo $this->generateLink('site_root');?>">Site</a> |</li>
		<li><a href="<?php echo $this->generateLink('user_logout');?>">Logout</a></li>
	</ul>
	<div class="clear"></div>
</div>