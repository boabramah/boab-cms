<html>
	<body>
		<h2>Welcome to <?php echo SITE_NAME;?>!</h2>

		<p>Thank you for signing up for an account on <?php echo SITE_NAME;?></p>

		<p> Please click on the link below to activate your account. If clicking the link below in this message does not work, copy and paste it into 
			the address bar of your browser:<br />
			<a href="<?php echo $this->activation_link;?>"><?php echo $this->activation_link;?></a>
		</p>

		<p>This email is a part of the procedure to register on the system, if you did not request this registration on our site, please, ignore this email. After a short time the request will be removed from the system.</p>

		<p>Regards,<br />
		The team at <?php echo SITE_NAME;?></p>
	</body>
</html>