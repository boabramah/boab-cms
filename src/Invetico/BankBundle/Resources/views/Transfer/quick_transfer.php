<div class="panel panel-white">
    <div class="panel-heading clearfix">
        <h4 class="panel-title">Quick Funds Transfer</h4>
    </div>
    <div class="panel-body">
        <form action="[link route_name=transfers_confirm params=transferType:local]" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">From Account</label>
				<select name="from_account" class="form-control m-b-sm">
                    <option value="0">-- Select account --</option>
                    <?php foreach($this->accounts as $account):?>
                    <option value="<?php echo $account->getAccountNumber();?>">
                        <?php echo sprintf('%s-%s',$account->getAccountName(),$account->getAccountNumber());?>
                    </option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">From Account</label>
				<select name="to_account" class="form-control m-b-sm">
                    <option value="0">-- Select account --</option>
                    <?php foreach($this->accounts as $account):?>
                    <option value="<?php echo $account->getAccountNumber();?>">
                        <?php echo sprintf('%s-%s',$account->getAccountName(),$account->getAccountNumber());?>
                    </option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="text" class="form-control" id="amount" name="transfer_amount">
            </div>
            <input type="hidden" name="transfer_date" value="<?php echo $this->transferDate;?>">
            <input name="description" type="hidden" value="Quick Transfer">
            <input name="transfer_frequency" type="hidden" value="0">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>