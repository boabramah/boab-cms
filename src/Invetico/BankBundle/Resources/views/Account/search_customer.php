<div id="customer-account-wrapper">
	<form id="search-customer" class="form-style" action="<?php echo $this->action;?>" method="POST">
	<p>Search Customer </p>
	<div class="row">
		<div id="search-type-wrapper">
			<div class="span"><span><input type="radio" name="search_type" value="account" checked=""></span><span class="label">Account Number</span></div>
			<div class="span"><span><input type="radio" name="search_type" value="name"></span><span class="label">Account Name</span></div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>	
	<div class="row">
		<input type="text" name="account_number" value="" placeholder="Enter account number or name"/>
		<?php echo $this->flash->getError('account_number',true);?>
	</div>	
	<div class="row">
		<input type="submit" id="search-customer-btn" name="submit" value="Search" class="submit-btn" />
	</div>
	</form>
</div>