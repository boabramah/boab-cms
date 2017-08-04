<div id="account-summary" class="panel panel-white">
    <div class="panel-heading clearfix">
        <h2 class="panel-title">Account Summary <span class="total">Total: [currency amount=<?php echo $this->accountSummaryBalance;?>]</span></h2>
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Account Name</th>
                    <th>Account Number</th>
                    <th>Account Type</th>
                    <th>Balance</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($this->accounts as $account):?>
                <tr>
                    <td>
                        <div><strong><a href="<?php echo $this->generate($account);?>"><?php echo $account->getAccountName();?></a></strong></div>
                        <span><?php echo $account->getDateCreated();?></span>
                    </td>
                    <td><?php echo $account->getAccountNumber();?></td>
                    <td><?php echo $account->getAccountTypeLabel();?></td>
                    <td class="align-right">[currency amount=<?php echo $account->getBalance();?>]</td>
                    <td>
                        <form class="account-form" method="post" action="<?php echo $this->generate($account);?>">
                            <div class="form-group col-sm-12">
                                <select name="account-options" id="account-options" class="form-control">
                                    <option value="0">--Select Option--</option>
                                    <option value="transactions">Transactions</option>
                                    <option value="deposit">Deposit</option>
                                    <option value="withdraw">Withdraw</option>
                                </select>
                            </div>
                        </form>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>