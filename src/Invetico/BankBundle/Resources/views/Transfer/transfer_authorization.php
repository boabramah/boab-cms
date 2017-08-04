<div class="row">
        <div class="panel panel-white">
            <div class="panel-body">
				<div class="alert alert-warning" role="alert">
					A token code has been sent to your email: <strong><?php echo $this->customer->getEmail();?></strong>
                </div>
                <p>You have 1 hour to insert the valid OTP. The system will automatically 
                redirect to "Fund Transfer" page to initiate fund transfer again</p>
            
				<form name="tokenValidationForm" id="tokenValidationForm" action="" method="POST">
					<div class="form-group" >
                        <label for="auth-code" class="col-sm-2 control-label">Transfer Authorization Code</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control input-sm" name="auth_code" id="auth-code" >
                        </div>
                    </div>
                    <div style="margin-bottom:20px "></div>
					<div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success">Submit Code</button>
                        </div>
                    </div>                    					
				</form>

            </div>
    </div>
</div>