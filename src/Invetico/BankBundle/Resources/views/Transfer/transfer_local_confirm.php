<div id="confirm-funds" class="panel panel-white funds-transfer">
     <div class="panel-heading clearfix align-center">
         <h2 class="panel-title">Confirm Transfer</h2>
     </div>    
    <div class="panel-body">
        <form action="[link route_name=transfers_save params=transferType:local]" method="post">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th colspan="2">Local - Funds transfer between Own Accounts <span class="steps">Step 2 of 3</span></th>
                    </tr>
                </thead>                                                
                <tbody>
                    <tr>
                    <td colspan="2" class="sub-heading"><span class="info">Please review data and confirm transfer</span></td>
                    </tr>                
                    <tr>
                        <td class="td-label">Account to be transfered from:</td>
                        <td>
                            <?php echo $this->fromAccount->getAccountName();?>
                            <input type="hidden" name="from_account" value="<?php echo $this->fromAccount->getAccountNumber();?>">                           
                        </td>
                    </tr>
                    <tr>
                        <td class="td-label">Account to be transfered to:</td>
                        <td >
                            <?php echo $this->toAccount->getAccountName();?>
                            <input type="hidden" name="to_account" value="<?php echo $this->toAccount->getAccountNumber();?>">                                                      
                        </td>
                    </tr>
                    <tr>
                        <td class="td-label">Amount to transfer:</td>
                        <td>
                            <?php echo $this->transferAmount;?>
                            <input class="form-control input-sm" type="hidden" name="transfer_amount" value="<?php echo $this->transferAmount;?>">
                        </td>
                    </tr>                    
                    <tr>
                        <td class="td-label">When to be paid:</td>
                        <td>
                            <?php echo $this->transferDate;?>
                            <input type="hidden" name="transfer_date"  value="<?php echo $this->transferDate;?>">
                        </td>
                    </tr> 
                    <tr>
                        <td class="td-label">Transfer Description:</td>
                        <td>
                            <?php echo $this->description;?>
                            <input name="description" type="hidden" value="<?php echo $this->description;?>">
                        </td>
                    </tr>                     
                    <tr>
                        <td class="td-label">Do you want to repeat this transfer?:</td>
                        <td>
                            <?php echo $this->isRepeatable;?>
                            <input name="is_repeatable" type="hidden" value="<?php echo $this->isRepeatableValue;?>">                            
                        </td>
                    </tr>                                        
                    <tr>
                        <td class="td-label">Frequency:</td>
                        <td>
                            <?php echo $this->transferFrequency;?>
                            <input name="transfer_frequency" type="hidden" value="<?php echo $this->transferFrequency;?>">
                        </td>
                    </tr>                                                                                                  
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td>
                            <div class="btn-submit-container">
                                <button class="btn btn-primary btn-medium">Confirms</button>
                            </div>                            
                        </td>
                    </tr>
                </tfoot>
            </table>

        </form>
    </div>
</div>