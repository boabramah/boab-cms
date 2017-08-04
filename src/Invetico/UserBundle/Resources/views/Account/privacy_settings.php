<div id="settings-privacy">
	<h3>Select all those alerts you want to be informed by Softmindia</h3>
	<form action="<?php echo $this->action;?>" method="POST">
		<ul>
			<li>
				<span class="check"><input <?php echo ($this->privacy->getRecieveNewsletter() === 1)?'checked':'';?> type="checkbox" name="recieve_newsletter" /></span>
				<span class="label">I want to receive the Softmindia newsletter</span>
			</li>
			<li>
				<span class="check"><input <?php echo ($this->privacy->getAdviceBuyingAndSelling() === 1)?'checked':'';?> type="checkbox" name="advice_buy_sell" /></span>
				<span class="label">I want to receive advice on buying and selling on Softmindia</span>
			</li>
		</ul>
		<h3>My Profile</h3>
		<ul>
			<li>
				<span class="check"><input <?php echo ($this->privacy->getShowAds() === 1)?'checked':'';?> type="checkbox" name="show_ads" /></span>
				<span class="label">Show my ads on my profile</span>
			</li>
			<li>
				<span class="check"><input <?php echo ($this->privacy->getShowComments() === 1)?'checked':'';?> type="checkbox" name="show_comment" /></span>
				<span class="label">Show comments on my profile</span>
			</li>
		</ul>
		<h3>Facebook</h3>
		<ul>
			<li>
				<span class="check"><input <?php echo ($this->privacy->getSigneInFacebook() === 1)?'checked':'';?> type="checkbox" name="facebook_sign_on" /></span>
				<span class="label">Automatically sign me in Softmindia when I am signed in Facebook</span>
			</li>
			<li>
				<span class="check"><input <?php echo ($this->privacy->getPostOnFacebook() === 1)?'checked':'';?> type="checkbox" name="ads_on_facebook" /></span>
				<span class="label">Automatically display new ads I post on my Facebook profile.</span>
			</li>
		</ul>
		<input type="submit" name="submit" value="submit" class="submit-btn"/>
	</form>
</div>
