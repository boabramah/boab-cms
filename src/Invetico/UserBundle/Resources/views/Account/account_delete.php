
<div id="settings-delete-account">
	<form class="form-style" action="<?php echo $this->action;?>" method="POST">
		<p>Enter Password to continue with your account deletion: </p>
		<ul>
			<li>
				<input type="password" name="password" value="" />
				<?php echo $this->flash->getError('password',true);?>
			</li>
			<li>
				<input type="submit" name="submit" value="Continue" class="submit-btn" />
			</li>
		</ul>
	</form>
</div>