<div id="account-detail" class="panel panel-white">
    <div class="panel-body">
        <form action="" method="post">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th colspan="2">Account Details</th>
                    </tr>
                </thead>                                                
                <tbody>
                    <tr>
                        <td>Date Opened:</td>
                        <td><?php echo $this->account->getDateCreated('d-m-Y h:i:s');?></td>
                    </tr>                
                    <tr>
                        <td>Account Number:</td>
                        <td><?php echo $this->account->getAccountNumber();?></td>
                    </tr>
                    <tr>
                        <td>Account Name:</td>
                        <td>
                            <input class="form-control" type="text" name="account_name" value="<?php echo $this->account->getAccountName();?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Account Type:</td>
                        <td><?php echo $this->account->getAccountTypeLabel();?></td>
                    </tr>
                    <tr>
                        <td>Interest Rate:</td>
                        <td>1.2%</td>
                    </tr>                    
                    <tr>
                        <td>Balance:</td>
                        <td><?php echo $this->account->getBalance();?></td>
                    </tr>
                    <tr>
                        <td>Available Balance:</td>
                        <td><?php echo $this->account->getBalance();?></td>
                    </tr>                                        
                </tbody>
            </table>
            <div class="btn-submit-container">
                <button class="btn btn-primary btn-medium">Submit</button>
            </div>
        </form>
    </div>
</div>