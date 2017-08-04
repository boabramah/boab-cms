<div id="funds-funds" class="panel panel-white funds-transfer">
     <div class="panel-heading clearfix align-center">
         <h2 class="panel-title">Local Transfer </h2>
        <p>This area allows you to move money from one account to another or make a payment to an eligible loan account. Your transfer can be set up for same day processing on any busuness day if entered prior to 8:00pm. Transfers entered after 8:00pm will be processed the next business day.</p>
     </div>    
    <div class="panel-body">
        <form action="[link route_name=transfers_confirm params=transferType:local]" method="post">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th colspan="2">Funds transfer between Own Accounts <span class="steps">Step 1 of 3</span></th>
                    </tr>
                </thead>                                                
                <tbody>
                    <tr>
                    <th colspan="2" class="sub-heading">Transfer Information</th>
                    </tr>                
                    <tr>
                        <td class="td-label">Account to be transfered from:</td>
                        <td>
                            <select name="from_account" id="from_account" class="form-control m-b-sm" style="max-width: 400px">
                                <option>--Select account--</option>
                                <?php foreach($this->accounts as $account):?>
                                    <option value="<?php echo $account->getAccountNumber();?>"><?php echo $account->getAccountName() .' - '.$account->getAccountNumber();?></option>
                                <?php endforeach;?>
                            </select>                            
                        </td>
                    </tr>
                    <tr>
                        <td class="td-label">Account to be transfered to:</td>
                        <td >
                        <select name="to_account" id="to_account" class="form-control m-b-sm input-md">
                            <option>--Select account--</option>
                            <?php foreach($this->accounts as $account):?>
                                <option value="<?php echo $account->getAccountNumber();?>"><?php echo $account->getAccountName() .' - '.$account->getAccountNumber();?></option>
                            <?php endforeach;?>
                        </select>                            
                        </td>
                    </tr>
                    <tr>
                        <td class="td-label">Amount to transfer:</td>
                        <td>
                            <input class="form-control input-sm" type="text" name="transfer_amount" value="">
                        </td>
                    </tr>                    
                    <tr>
                        <td class="td-label">When to be paid:</td>
                        <td>
                            <div class="input-group input-group-md input-sm">
                                <input class="form-control date-picker" type="text" name="transfer_date"  value="">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>                                            
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-label">Transfer Description:</td>
                        <td>
                            <textarea class="form-control input-md" name="description"></textarea>
                        </td>
                    </tr>                     
                    <tr>
                        <th colspan="2" class="sub-heading">Transfer Schedule</th>
                    </tr>                    
                    <tr>
                        <td class="td-label">Do you want to repeat this transfer?:</td>
                        <td>
                            <div class="checkbox">
                                <label style="padding:0px">
                                    <div class="checker">
                                        <span><input name="is_repeatable" type="checkbox"></span>
                                    </div>

                                </label>
                            </div>
                        </td>
                    </tr>                                        
                    <tr>
                        <td class="td-label">Frequency:</td>
                        <td>
                            <div class="input-sm">
                                <select name="transfer_frequency" id="transfer_frequency" class="form-control m-b-sm">
                                    <option value="0">--Select frequency--</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                </select> 
                            </div>
                            <p class="help-block">Leave blank if repeat is not checked.</p>
                        </td>
                    </tr>                                                                          
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td>
                            <div class="btn-submit-container">
                                <button class="btn btn-primary btn-medium">Next Step</button>
                            </div>                            
                        </td>
                    </tr>
                </tfoot>
            </table>

        </form>
    </div>
</div>