                    <div class="row">
                        <div class="col-md-12">
                            <div id="transactions" class="panel panel-white">
                                <div class="panel-heading clearfix">
                                <h2 class="panel-title">Transfer History</h2>
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
                                    <table id="transfer-history-data" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead>
                                            <tr>
                                                <th style="width:80px">Date</th>
                                                <th>Reference</th>
                                                <th>From Account</th>
                                                <th>To Account</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($this->collection as $transfer):?>
                                                <tr class=" row-<?php echo $transfer->getId();?>">
                                                    <td style="vertical-align: middle"><?php echo $transfer->getDateCreated('d-m-Y');?></td>
                                                    <td style="vertical-align: middle"><?php echo $transfer->getReferenceNumber();?></td>
                                                    <td style="vertical-align: middle"><?php echo $transfer->getFromAccount();?></td>
                                                    <td style="vertical-align: middle"><?php echo $transfer->getToAccount();?></td>
                                                    <td style="vertical-align: middle"><?php echo $transfer->getDescription();?></td>
                                                    <td style="vertical-align: middle" class="align-right"><?php echo currency($transfer->getAmount());?></td>
                                                    <td style="vertical-align: middle" class="transfer-status"><?php echo ucFirst($transfer->getStatus());?></td>
                                                    <td style="vertical-align: middle" class="approve-box">
                                                        <img class="ajax-loader" src="<?php echo BASE_URL;?>images/ajax-loader.gif" />
                                                        <a href="<?php echo $this->generateApproveUrl($transfer);?>" class="transfer-approve" data-transfer-id="<?php echo $transfer->getId();?>">
                                                            Approve
                                                        </a>
                                                    </td>
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