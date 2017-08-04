

<div class="big-padding">
	<div id="forget-password-form-wrapper" class="box-style bash-form">
		<h2>Reset Password</h2>
		<p class="info">Please note that we will send a password reset link to your email. So do well to check it.</p>
		<form id="forget-password-form" action="<?php echo $this->action;?>" method="post" >				
			<?php echo $this->flash->getInfo();?>
			<input placeholder="Email address" name="email" type="text" class="fields" id="email" size="30" value="<?php echo $this->flash->getData('email');?>"/> 
			<?php echo $this->flash->getError('email',true);?>
			<input name="submit" type="submit" class="button" id="submit" value="Submit" />
		</form>
		<a class="extra forget-password" href="[link route_name='_login']">Login</a>
	</div>
</div>