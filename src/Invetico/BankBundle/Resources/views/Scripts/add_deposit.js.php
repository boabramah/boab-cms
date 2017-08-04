	<script id="customer-payment-template" type="text/x-handlebars-template">		
			<div id="customer-deposit-wrapper" class="ajax-form-style">
				<h2>{{title}}</h2>			
				<form id="customer-payment-form" class="form-style" action="{{action}}" method="POST">
				<div class="row">
					<p>Payment Type: </p>
					<select id="payment-type" name="paymentType">
						<option value="0">--- Select Payment Type ---</option>
						<option selected value="DP">Deposit</option>
						<option value="LON">Loan</option>
						<option value="HP">Hire Purchase</option>					
						<option value="INV">Investment</option>					
					</select>
					{{#if errors.paymentType}}
						<span class="error">{{errors.paymentType}}</span>
					{{/if}}
				</div>
				<div class="row">
					<p>Amount: </p>
					<input type="text" name="amount" value="" />
					{{#if errors.amount}}
						<span class="error">{{errors.amount}}</span>
					{{/if}}
				</div>
				<div class="row submit-btn-wrapper">
					<input type="submit" id="customer-payment-btn" name="submit" value="submit" class="submit-btn" />
				</div>
				</form>
			</div>
	</script>