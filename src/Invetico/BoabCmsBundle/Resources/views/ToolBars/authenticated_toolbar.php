<ul>
	<li><a href="#" class="user-name">Welcome <?php echo $this->userName;?></a>
		<ul id="account">
			<li><a href="<?php echo $this->urlGenerator->generate('account_home');?>">Account</a></li>
			<li><a href="<?php echo $this->urlGenerator->generate('user_settings_index');?>">Settings</a></li>
			<li><a href="<?php echo $this->urlGenerator->generate('user_logout');?>">Logout</a></li>
		</ul>
	</li>
</ul>

