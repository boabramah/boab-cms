


<div id="officer-transactions-container">
	<form action="<?php echo $this->apiOfficerTransactionsUrl;?>" method="post">
		<input type="text" name="_nolimit" value="1" style="display:none">
		<div id="officer-transaction-criteria">
			<ul>
				<li><input type="text" name="start_date" placeholder="Start Date" value="<?php echo $this->startDate;?>" /></li>
				<li><input type="text" name="end_date" placeholder="End Date" value="<?php echo $this->endDate;?>" /></li>
				<li><input type="submit" id="search-transaction-btn" name="search-transaction-btn" value="submit" ></li>
			</ul>
			<div class="clear"></div>
		</div>
		<table style="width:100%" id="officer-transactions" class="data-list" data-source="<?php echo $this->apiOfficerTransactionsUrl;?>">
				<thead>
					<tr>
						<th><input id="all-check-box" type="checkbox" name="checkbox"></th>						
						<th width="100">Date</th>
						<th>Account Name</th>
						<th>Account Number</th>
						<th>Relation Officer</th>
						<th>Payment Type</th>
						<th class="right">Amount</th>
					</tr>
				</thead>
				<tbody>
	
				</tbody>
		</table>
		<div id="action-btn-container">
			[simplewidget role="ROLE_SUPER_ADMIN"]<a class="download-report-link" data-format="pdf" href="#" data-source-url="<?php echo $this->generateReportUrl('pdf');?>">Download as PDF</a>[/simplewidget]
			[simplewidget role="ROLE_SUPER_ADMIN"]<a class="download-report-link" data-format="excel" href="#" data-source-url="<?php echo $this->generateReportUrl('excel');?>">Download as EXCEL</a>[/simplewidget]
			[simplewidget role="ROLE_SUPER_ADMIN"]<a class="download-report-link" data-format="csv" href="#" data-source-url="<?php echo $this->generateReportUrl('csv');?>">Download as CSV</a>[/simplewidget]
		</div>
	</form>
</div>


