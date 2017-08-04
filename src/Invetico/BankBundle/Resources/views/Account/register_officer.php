
<div id="officer-create-form-wrapper">
	<div id="register-form-wrapper" class="box-style bash-form ">
		<?php echo $this->flash->getInfo() . $this->flash->getErrorNotice();?>
		<h2>Registration Form</h2>
		<form id="register-form" action="<?php echo $this->action;?>" method="post" >
			<input type="hidden" name="user_country" value="<?php echo $this->country->getId()?>">
			<div id="purpose">
				<span style="width:90px">Account Type: </span>
				<span style="width:105px;"><input type="radio" name="account_type" value="admin"  /><label>Administrator</label></span>
				<span style="width:85px"><input type="radio" name="account_type" value="officer" checked /><label>Officer</label></span>
			</div>
			<div>
				<input placeholder="Username" name="username" type="text" class="fields" id="username" size="30" value="<?php echo $this->flash->getData('username');?>"/> 
				<?php echo $this->flash->getError('username',true);?>
			</div>
			<div>
				<input placeholder="First Name" name="user_first_name" type="text" class="fields" id="user_first_name" size="30" value="<?php echo $this->flash->getData('user_first_name');?>"/> 
				<?php echo $this->flash->getError('user_first_name',true);?>
			</div>
			<div>
				<input placeholder="Last Name" name="user_last_name" type="text" class="fields" id="user_last_name" size="30" value="<?php echo $this->flash->getData('user_last_name');?>"/> 
				<?php echo $this->flash->getError('user_last_name',true);?>
			</div>
			<div>
				<input placeholder="Email address" name="email" type="text" class="fields" id="email" size="30" value="<?php echo $this->flash->getData('email');?>"/> 
				<?php echo $this->flash->getError('email',true);?>
			</div>
			<div>
				<input placeholder="Password" name="password" type="password" class="fields" id="password" size="30" />
				<?php echo $this->flash->getError('password',true);?>
			</div>
			<div>
				<input placeholder="Confirm Password" name="confirm_password" type="password" class="fields" id="password" size="30" />
				<?php echo $this->flash->getError('confirm_password',true);?>
			</div>
			<input name="submit" type="submit" class="button" id="submit" value="Sign Up" />
		</form>
	</div>
</div>