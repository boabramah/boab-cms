
<div id="settings-profile">
	<form  action="<?php echo $this->action;?>" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="user_id" value="<?php echo $this->user->getId();?>">
		<div class="form-group">
			<label>First Name: </label>
			<input class="form-control" type="text" name="user_first_name" value="<?php echo $this->user->getFirstname();?>" />
			<?php echo $this->flash->getError('user_first_name',true);?>
		</div>
		<div class="form-group">
			<label>Last Name: </label>
			<input class="form-control" type="text" name="user_last_name" value="<?php echo $this->user->getLastname();?>" />
			<?php echo $this->flash->getError('user_last_name',true);?>
		</div>
		<div class="form-group">
			<label>Contact Number: </label>
			<input class="form-control"type="text" name="user_contact_number" value="<?php echo $this->user->getContactnumber();?>" />
			<?php echo $this->flash->getError('user_contact_number',true);?>
		</div>
		<div class="form-group">
			<label >Email: </label>
			<input class="form-control" type="text" name="user_email" value="<?php echo $this->user->getEmail();?>" />
			<?php echo $this->flash->getError('user_email',true);?>
		</div>
		<div class="form-group">
			<label >Country: </label>
			<select id="user_country" name="user_country" class="input-select">
				<?php echo $this->countriesOption;?>
			</select>
			<?php echo $this->flash->getError('user_country',true);?>
		</div>
		<div class="form-group">
			<label >City: </label>
			<input class="form-control" type="text" name="user_city" value="<?php //echo $this->user->getCity();?>" />
			<?php echo $this->flash->getError('user_city',true);?>
		</div>
		<div class="form-group">
			<label >Address: </label>
			<input class="form-control" type="text" name="user_address" value="<?php //echo $this->user->getAddress();?>" />
			<?php echo $this->flash->getError('user_address',true);?>
		</div>
		<div class="form-group">
			<label>Postal code: </label>
			<input class="form-control" type="text" name="user_postalcode" value="<?php //echo $this->user->getPostalcode();?>" />
			<?php echo $this->flash->getError('user_postalcode',true);?>
		</div>
		<button class="btn btn-green isThemeBtn" id="submit">submit</button>
	</form>
</div>