
<div id="settings-password">
	<form  action="<?php echo $this->action;?>" method="POST">
		<div class="form-group">
			<label>Current Password: </label>
			<input class="form-control" type="password" name="current_password" value="" />
			<?php echo $this->flash->getError('current_password',true);?>
		</div>
		<div class="form-group">
			<label>New Password: </label>
			<input class="form-control" type="password" name="password1" value="" />
			<?php echo $this->flash->getError('password1',true);?>
		</div>
		<div class="form-group">
			<label>Confirm Password: </label>
			<input class="form-control" type="password" name="password2" value="" />
			<?php echo $this->flash->getError('password2',true);?>
		</div>
		<button class="btn btn-green isThemeBtn" id="submit">submit</button>
	</form>
</div>