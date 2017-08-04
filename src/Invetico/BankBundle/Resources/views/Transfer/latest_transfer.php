                            
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">Latest Transfer History</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>From Account</th>
                                                <th>To Account</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($this->transfers as $transfer):?>
                                            <tr>
                                                <th><?php echo $transfer->getFromAccount();?></th>
                                                <td><?php echo $transfer->getToAccount();?></td>
                                                <td>[currency amount=<?php echo $transfer->getAmount();?>]</td>
                                                <td><?php echo ucfirst($transfer->getStatus());?></td>
                                            </tr>
                                            <?php endforeach;?>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>