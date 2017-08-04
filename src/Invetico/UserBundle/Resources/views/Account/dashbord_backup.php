<div id="control-panel">
	<?php echo $this->posting_top_widget;?>
	<div class="wrapper box-square-2">

		<div id="content-block">
			<?php  echo $this->flash_error_messages . $this->flash_success_messages . $this->flash_info_messages;?>
			<h2 id="account-page-header"><?php echo $this->page_header;?></h2>
			<?php echo $this->content;?>
			<div class="clear"></div>
		</div>

		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>