<html>
	<body>
		<h2>Transfer Authorization Code</h2>
		<br>
		Please use the code below to authorize your transfer.
		<br>
		<br>
		Here is your code: <strong><?php echo $this->transfer->getAuthorizationCode();?></strong>
		<br>
		<br>

		If you did not initiate this transfer, ignore this message. The transfer will be terminated.
		<br>
		<br>
		
		Thanks,<br />
		The team at <?php echo SITE_NAME;?>
	</body>
</html>