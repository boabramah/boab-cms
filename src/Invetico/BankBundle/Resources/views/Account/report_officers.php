<html>
	<head>
		<style>
			*{margin: 0px;padding: 0px}
			@page {
			  size: A4;
			}	
			#container{width:100%;margin: 0px auto;padding: 50px 0px;padding: 20px}
			table#header h1{font-size: 18px;text-transform: uppercase;}
			table#header h3{margin-bottom: 28px;font-size: 20px;font-weight: normal;}
			table#header td{padding: 10px 0px}
			.data-list{font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 12px;text-align: left;border-collapse: collapse;background-color: #fff;}
			.data-list a {color: #6A6A6A}
			.data-list tr a:hover {text-decoration: underline;}
			.data-list th{font-size: 12px;font-weight: normal;padding: 8px;background-color: #057A67;color: #AFE9D7;font-weight: bold;text-transform: uppercase;}
			.data-list td{padding: 8px; color: #000;border-bottom: 1px solid #CCCCCC;}
			.data-list  .label{font-weight:bold;color:#A5856E;vertical-align:top;width:170px;word-wrap:break-word;}
			.data-list  span.label{font-weight:bold;color:#A5856E;vertical-align:top;width:100px;display:block;height:100%;}
			.data-list tr div.data{min-height:50px;line-height:1.5em;}
			.data-list tfoot tr td{font-size: 12px;color: #000;}
			.data-list tbody tr:nth-child(even) {background-color: #EBF3F0;}
			.data-list td.currency{text-align: right}
			.data-list td.data-processing{text-align: center;font-size: 13px}
			table td.right,table th.right{text-align: right}
			table td.left,table th.left{text-align:left}
			table tfoot td{font-weight: bold}
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
				<td class="right">Date:...........................................</td>
			</tr>
			<tr>
				<td>Officer Name:.................................................</td>
				<td class="right">Sign:...........................................</td>
			</tr>	
		</tbody>	
	</table>
	<table class="data-list" width="100%" id="body">
		<thead>
			<tr>
				<th class="left">Officer</th>
				<th class="right">Amount</th>
			</tr>
		</thead>
		<tbody>

			<?php foreach($this->collection->getOfficers() as $officer):?>
			<tr>
				<td><?php echo $officer->getOfficerName();?></td>
				<td class="right"><?php echo $officer->getAmount();?></td>
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
</html>