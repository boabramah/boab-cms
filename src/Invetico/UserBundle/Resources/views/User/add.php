
<div id="register-form-wrapper">
	<form id="register-form" action="<?php echo $this->action;?>" method="post" enctype="multipart/form-data">
		<div class="tabsContainer">
			<div id="form-container">
			<div class="tab-pane form-column-container active">	
			<div class="form-group">
				<label>Username</label>
				<input name="username" type="text" class="form-control" id="username" size="30" value="<?php echo $this->flash->getData('username');?>"/>
				<?php echo $this->flash->getError('username',true);?>
			</div>
			<div class="form-group">
				<label>First Name</label>
				<input name="user_first_name" type="text" class="form-control" id="user_first_name" size="30" value="<?php echo $this->flash->getData('user_first_name');?>"/>
				<?php echo $this->flash->getError('user_first_name',true);?>
			</div>
			<div class="form-group">
				<label>Last Name</label>
				<input name="user_last_name" type="text" class="form-control" id="user_last_name" size="30" value="<?php echo $this->flash->getData('user_last_name');?>"/>
				<?php echo $this->flash->getError('user_last_name',true);?>
			</div>
			<div class="form-group">
				<label>Email Address</label>
				<input name="email" type="text" class="form-control" id="email" size="30" value="<?php echo $this->flash->getData('email');?>"/>
				<?php echo $this->flash->getError('email',true);?>
			</div>
			<div class="form-group">
				<label>Contact Number</label>
				<input name="contact_number" type="text" class="form-control" id="email"  value="<?php echo $this->flash->getData('contact_number');?>"/>
				<?php echo $this->flash->getError('contact_number',true);?>
			</div>		
							
			<div class="form-group">
				<label>Password</label>
				<input name="password" type="password" class="form-control" id="password"  />
				<?php echo $this->flash->getError('password',true);?>
			</div>
			<div class="form-group">
				<label>Confirm Password</label>
				<input name="confirm_password" type="password" class="form-control" id="password"  />
				<?php echo $this->flash->getError('confirm_password',true);?>
			</div>
			<input name="submit" type="submit" class="button" id="signup-btn" value="Sign Up" />
		</div>
		</div>
		</div>
	</form>
</div>
