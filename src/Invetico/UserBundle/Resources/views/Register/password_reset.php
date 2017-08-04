	<div class="big-padding">
		<div id="reset-password-form-wrapper" class="box-style bash-form">
			
			<form id="reset-password-form" action="<?php echo $this->action;?>" method="post" >
				<h2>Reset Password</h2>
				<?php echo $this->flash->getError('retry',true) . $this->flash->getInfo();?>
				<p>Please note that if you forget your password frequently, you are advice to write it down for easy access.</p>
				<input name="email" type="hidden" value="<?php echo $this->flash->getValue('email');?>" /> 
				<input placeholder="New Password" name="password" type="password" class="fields" id="password" size="30" /> 
				<span class="error"><?php echo $this->flash->getError('password');?></span>
				<input placeholder="Confirm Password" name="confirm_password" type="password" class="fields" id="confirm_password" size="30" /> 
				<span class="error"><?php echo $this->flash->getError('confirm_password');?></span>
				<input name="submit" type="submit" class="button" id="submit" value="Submit" />
			</form>
			<a class="extra forget-password" href="[link route_name='_login']">Login</a>
		</div>
	</div>