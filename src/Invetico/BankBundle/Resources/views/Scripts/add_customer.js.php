	<script id="add-customer-tpl" type="text/x-handlebars-template">
		<div id="customer-form-wrapper" class="ajax-form-style">
			<form id="add-customer-form" class="form-style" action="{{action}}" method="POST">
				<h2>{{title}}</h2>
				<div class="row">
					<p>Customer Account Name: </p>
					<input type="text" name="accountName" value="{{account.accountName}}" />
					{{#if errors.accountName}}
						<span class="error">{{errors.accountName}}</span>
					{{/if}}
				</div>
				<div class="row">
					<p>Customer Account Number: </p>
					<input type="text" name="accountNumber" value="{{account.accountNumber}}" />
					{{#if errors.accountNumber}}
						<span class="error">{{errors.accountNumber}}</span>
					{{/if}}
				</div>
				<div class="row">
					<p>Contact Number: </p>
					<input type="text" name="contactNumber" value="{{account.contactNumber}}" />
					{{#if errors.contactNumber}}
						<span class="error">{{errors.contactNumber}}</span>
					{{/if}}			
				</div>	
				<div class="row submit-btn-wrapper">
					<input type="submit" id="{{submitId}}" name="submit" value="submit" class="submit-btn" />
				</div>
			</form>
		</div>	
	</script>