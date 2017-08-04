<div id="officer-transactions-container">

		<div id="officer-transaction-criteria">
			<ul>
				<li><input type="text" name="start_date" placeholder="Start Date" value="<?php echo $this->startDate;?>" /></li>
				<li><input type="text" name="end_date" placeholder="End Date" value="<?php echo $this->endDate;?>" /></li>
				<li><input type="submit" id="search-transaction-btn" name="search-transaction-btn" value="submit" ></li>
			</ul>
			<div class="clear"></div>
		</div>
		<table style="width:100%" id="officer-transactions" class="data-list" data-source="<?php echo $this->transactionsUrl;?>">
				<thead>
					<tr>
						<th><input id="all-check-box" type="checkbox" name="checkbox"></th>
						<th width="150">Date</th>
						<th>Account Name</th>
						<th>Account Number</th>
						<th>Relation Officer</th>
						<th>Payment Type</th>
						<th>Amount</th>
					</tr>
				</thead>
				<tbody>
	
				</tbody>
		</table>
		<div id="action-btn-container">
			[simplewidget role="ROLE_SUPER_ADMIN"]<a id="delete-transact-btn" data-source-url="<?php echo $this->deleteTransactionUrl;?>" href="#">Delete Selected Transactions</a>[/simplewidget]			
			[simplewidget role="ROLE_SUPER_ADMIN"]<a class="download-report-link" data-source-url="<?php echo $this->generateReportUrl('pdf');?>" href="#">Download All transactions</a>[/simplewidget]
			[simplewidget role="ROLE_SUPER_ADMIN"]<a class="download-report-link" data-source-url="<?php echo $this->groupByOfficerUrl;?>" href="#">Download Report By Officers</a>[/simplewidget]			
		</div>
	</form>
</div>
<div id="preparing-file-modal" title="Preparing report..." style="display: none;">
    We are preparing your report, please wait...
 
    <div class="ui-progressbar-value ui-corner-left ui-corner-right" style="width: 100%; height:22px; margin-top: 20px;"></div>
</div>
 
<div id="error-modal" title="Error" style="display: none;">
    There was a problem generating your report, please try again.
</div>