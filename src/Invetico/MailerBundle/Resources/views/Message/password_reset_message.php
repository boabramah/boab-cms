<html>
<body>
	<p>Hello <?php echo $this->user->getFirstname() .' ' .$this->user->getLastname();?>,</p>

	<p>A request was received, hopefully from you, to reset your accounts password. 
	Use the following link within the next 24 hours to reset your password and be able to access 
	the site.</p>

	<p><a href="<?php echo $this->passwordResetLink;?>"><?php echo $this->passwordResetLink;?></a></p>

	<p>If you didn't request this security code, you can safely ignore this email. 
	It's possible that another user entered your email address by mistake when 
	trying to reset their own password.</p>

	<p>Thanks,<br />

	</body>
</html>