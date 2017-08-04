<div id="officer-transactions-container">
	<form action="<?php echo $this->transactionSearchUrl;?>" method="post">
		<div id="officer-transaction-criteria">
			<ul>
				<li><input type="text" name="start_date" placeholder="Start Date" value="<?php echo $this->startDate;?>" /></li>
				<li><input type="text" name="end_date" placeholder="End Date" value="<?php echo $this->endDate;?>" /></li>
				<li><input type="submit" id="search-transaction-btn" name="search-transaction-btn" value="submit" ></li>
			</ul>
			<div class="clear"></div>
		</div>
		<table style="width:100%" id="officer-transactions" class="data-list" data-source="<?php echo $this->officerTransactionsUrl;?>">
				<thead>
					<tr>
						<th><input id="all-check-box" type="checkbox" name="checkbox"></th>						
						<th width="200">Date</th>
						<th>Account Name</th>
						<th>Account Number</th>
						<th>Payment Type</th>
						<th>Amount</th>
					</tr>
				</thead>
				<tbody>
	
				</tbody>
		</table>
		<div id="download-report-container">
			<a class="download-report-link" download data-format="pdf" data-source-url="<?php echo $this->generateReportUrl('pdf');?>" href="#">Download Report</a>
			<a class="download-report-link" download data-format="excel" data-source-url="<?php echo $this->generateExportUrl('excel');?>" href="#">Export to EXCEL</a>
			<a class="download-report-link" download data-format="csv" data-source-url="<?php echo $this->generateExportUrl('csv');?>" href="#">Export CSV</a>
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