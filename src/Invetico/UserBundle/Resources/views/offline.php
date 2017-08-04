<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<script type="text/javascript" src="<?php echo MEDIA_URL ?>js/jquery-1.4.2.js"></script>
	<script language="Javascript" type="text/javascript" src="<?php echo MEDIA_URL;?>js/jquery.lwtCountdown-1.0.js"></script>
	<script language="Javascript" type="text/javascript" src="<?php echo MEDIA_URL;?>js/misc.js"></script>
	<link rel="Stylesheet" type="text/css" href="<?php echo MEDIA_URL;?>css/main.css"></link>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<title><?php echo $pageTitle; ?></title>
</head>

<body>

	<div id="container">

		<h1>UNDER CONSTRUCTION</h1>
		<h2 class="subtitle">Stay tuned for news and updates.</h2>

		<!-- Countdown dashboard start -->
		<div id="countdown_dashboard">
			<div class="dash weeks_dash">
				<span class="dash_title">weeks</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>

			<div class="dash days_dash">
				<span class="dash_title">days</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>

			<div class="dash hours_dash">
				<span class="dash_title">hours</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>

			<div class="dash minutes_dash">
				<span class="dash_title">minutes</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>

			<div class="dash seconds_dash">
				<span class="dash_title">seconds</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>

		</div>
		<!-- Countdown dashboard end -->

		<script language="javascript" type="text/javascript">
			jQuery(document).ready(function() {
				$('#countdown_dashboard').countDown({
					targetDate: {
						'day': 		21,
						'month': 	5,
						'year': 	2012,
						'hour': 	0,
						'min': 		0,
						'sec': 		0
					}
				});
				
				$('#email_field').focus(email_focus).blur(email_blur);
				$('#subscribe_form').bind('submit', function() { return false; });
			});
		</script>
	
	</div>
</body>

</html>
