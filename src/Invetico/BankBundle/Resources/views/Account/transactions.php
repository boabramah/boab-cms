                    <div class="row">
                        <div class="col-md-12">
                            <div id="transactions" class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h2 class="panel-title"><?php echo $this->account->getAccountName();?> </h2>
                                            <span><label>Acct/No: </label><?php echo $this->account->getAccountNumber();?></span> 
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <h2 class="panel-title"><span class="balance">Available Balance: [currency amount=<?php echo $this->account->getBalance();?>]</span></h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                <form action="" method="POST">
                                    <div id="officer-transaction-criteria">
                                        <div class="row">
                                            <div class="col-md-6">
                                                
                                                    <div class="row">
                                                    <div class="date-filter-container">
                                                        <div class="col-md-5">
                                                            <div class="input-group input-group-md">
                                                                <input class="form-control date-picker" type="text" name="start_date" placeholder="Start Date" value="<?php echo $this->start_date;?>">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </span>                                            
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="input-group input-group-md">
                                                                <input class="form-control date-picker" type="text" name="end_date" placeholder="End Date" value="<?php echo $this->end_date;?>">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </span>                                            
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary btn-medium" id="search-transaction-btn">SUBMIT</button></li>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="form-group filter-container">
                                                            <input type="text" class="form-control" id="search_filter" placeholder="Filter results">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>                                
                                    <div class="table-responsive">
                                    <table id="transaction-data" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th class="align-center">Withdrawal</th>
                                                <th class="align-center">Deposit</th>
                                                <th>Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($this->transactions as $transaction):?>
                                                <tr>
                                                    <td><?php echo $transaction->getDateCreated('d-m-Y');?></td>
                                                    <td><?php echo $transaction->getDescription();?></td>
                                                    <td class="align-center"><?php echo $transaction->getDebitAmount();?></td>
                                                    <td class="align-center"><?php echo $transaction->getCreditAmount();?></td>
                                                    <td class="align-right"><?php echo currency($transaction->getBalance());?></td>
                                                </tr>
                                            <?php endforeach;?>
                                        </tbody>
                                       </table>  
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>