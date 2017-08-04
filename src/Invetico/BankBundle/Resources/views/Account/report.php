<html>
	<head>
		<style>
			*{margin: 0px;padding: 0px}
			@page {
			  size: A4;
			}	
			#container{width:100%;margin: 0px auto;padding: 50px 0px;padding: 20px}
			table{width:100%;}
			table#header h1{font-size: 18px;text-transform: uppercase;}
			table#header h3{margin-bottom: 28px;font-size: 20px;font-weight: normal;}
			table#header td{padding: 10px 0px;font-size: 12px}
			table td{font-size: 12px}
			.data-list{font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 12px;text-align: left;border-collapse: collapse;background-color: #fff;}
			.data-list a {color: #6A6A6A}
			.data-list tr a:hover {text-decoration: underline;}
			.data-list th{font-size: 9px;font-weight: normal;padding: 10px;background-color: #057A67;color: #AFE9D7;font-weight: bold;text-transform: uppercase;}
			.data-list td{padding: 10px; color: #000;border-bottom: 1px solid #CCCCCC;}
			.data-list  .label{font-weight:bold;color:#A5856E;vertical-align:top;width:170px;word-wrap:break-word;}
			.data-list  span.label{font-weight:bold;color:#A5856E;vertical-align:top;width:100px;display:block;height:100%;}
			.data-list tr div.data{min-height:50px;line-height:1.5em;}
			.data-list tfoot tr td{font-size: 9px;color: #000;}
			.data-list tbody tr:nth-child(even) {background-color: #EBF3F0;}
			.data-list td.currency{text-align: right}
			.data-list td.data-processing{text-align: center;font-size: 13px}
			table td.right,table th.right{text-align: right}
			table tfoot td{font-weight: bold}
            span.print-name{display: block;padding-left: 116px;margin-bottom: -10px;}	
			span.print-date{display: block;padding-right: 5px;margin-bottom: -10px;} 

			#summary-box{width: 50%;margin:0px auto;margin-top: 50px}           		
			#summary-box h2{font-size: 10px;text-transform: uppercase;text-align: center;margin-bottom: 10px}           		
			#summary-box .box{margin-bottom: 20px}           

			#signat td{border:none;}		
			#signat tr{background-color: #fff}		
		</style>
	</head>
	<div id="container">
		<table width="100%" id="header">
			<thead>
				<tr>
					<th colspan="2">
						<h1>Wintrust Capital Microfinance Limited</h1>
						<h3>Daily Field Report Sheet</h3>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Batch Number:.................................................</td>
					<td class="right">
						<span class="print-date"><?php echo $this->date;?></span>
						<span>Date:...........................................</span>
					</td>
				</tr>
				<tr>
					<td>
						<span class="print-name"><?php echo $this->officer->getFullName();?></span>
			  			<span>Officer Name:.................................................</span>
			  		</td>
					<td class="right">Sign:...........................................</td>
				</tr>	
			</tbody>	
		</table>
		<table class="data-list" width="100%" id="body">
			<thead>
				<tr>
					<th>Date</th>
					<th>Account Name</th>
					<th>Account Number</th>
					<th>Payment Type</th>
					<th class="right">Amount</th>
				</tr>
			</thead>
			<tbody>

				<?php foreach($this->collection->getPayments() as $payment):?>
				<tr>
					<td><?php echo $payment->getDate();?></td>
					<td><?php echo $payment->getAccountName();?></td>
					<td><?php echo $payment->getAccountNumber();?></td>
					<td><?php echo $payment->getPaymentType();?></td>
					<td class="right"><?php echo $payment->getAmount();?></td>
				</tr>
				<?php endforeach;?>			

			</tbody>
			<tfoot>
				<tr>
					<td colspan="4" style="text-align:right">Total:</td>
					<td class="right"><?php echo $this->collection->getTotalAmount();?></td>
				</tr>
			</tfoot>
		</table>
		<div id="summary-box" >
			<div class="box">
				<h2>Payment Summary</h2>
				<table class="data-list">
					<thead>
						<tr>
							<th>Payment Type</th>
							<th class="right">Amount</th>
						</tr>
					</thead>
					
					<tbody>
						<?php foreach($this->paymentsSummary as $key => $amount):?>
						<tr>
							<td><?php echo paymentType($key);?></td>
							<td class="right"><?php echo $amount;?></td>
						</tr>
						<?php endforeach;?>			
					</tbody>

					<tfoot>
						<tr>
							<td style="text-align:right">Total:</td>
							<td class="right"><?php echo $this->collection->getTotalAmount();?></td>
						</tr>
					</tfoot>
				</table>
			</div>

			<div class="box">
				<h2>Notes</h2>
				<table class="data-list">
					<thead>
						<tr>
							<th>Denomination</th>
							<th>Quantity</th>
							<th>Amount</th>
						</tr>
					</thead>
					
					<tbody>
						<tr>
							<td>50</td>
							<td></td>
							<td></td>
						</tr>	
						<tr>
							<td>20</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>10</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>5</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>2</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>1</td>
							<td></td>
							<td></td>
						</tr>																															
					</tbody>

					<tfoot>
						<tr>
							<td>Total:</td>
							<td class="right"></td>
							<td class="right"></td>
						</tr>
					</tfoot>
				</table>
			</div>	

			<div class="box">
				<h2>Coins</h2>
				<table class="data-list">
					<thead>
						<tr>
							<th>Denomination</th>
							<th>Quantity</th>
							<th>Amount</th>
						</tr>
					</thead>
					
					<tbody>
						<tr>
							<td>1.50</td>
							<td></td>
							<td></td>
						</tr>	
						<tr>
							<td>0.50</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>0.20</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>0.10</td>
							<td></td>
							<td></td>
						</tr>																														
					</tbody>

					<tfoot>
						<tr>
							<td>Total:</td>
							<td class="right"></td>
							<td class="right"></td>
						</tr>
					</tfoot>
				</table>
			</div>	


			<div class="box">
				<table class="data-list" id="signat">
					
					<tbody>
						<tr>
							<td class="right">Recieved by:</td>
							<td>.................................................................................</td>
						</tr>	
						<tr>
							<td class="right">Sign</td>
							<td>.................................................................................</td>
							<td></td>
						</tr>
						<tr>
							<td class="right">Cash Supplus: </td>
							<td>.................................................................................</td>
							<td></td>
						</tr>
				</table>
			</div>						

		</div>
	</div>
</html>