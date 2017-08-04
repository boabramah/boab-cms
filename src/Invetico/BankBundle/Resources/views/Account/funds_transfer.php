                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body">
                                        <form id="wizardForm" method="post" action="[link route_name=transfers_process]">
                                            <div class="row m-b-lg">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <label for="senderAccount">Account to transfer from</label>
                                                                    <select name="senderAccount" id="senderAccount" class="form-control m-b-sm">
                                                                        <option>--Select account--</option>
                                                                        <option>Savings Account</option>
                                                                        <option>Checking Account</option>
                                                                        <option>Fixed Deposit Account</option>
                                                                    </select>
                                                                </div>                                                                

                                                                <div class="form-group col-md-12">
                                                                    <label for="receiverBankName">Receiver's Bank Name</label>
                                                                    <input type="text" class="form-control" name="receiverBankName" id="receiverBankName">
                                                                </div>
                                                                <div class="form-group  col-md-12">
                                                                    <label for="receiverFullName">Receiver's Name</label>
                                                                    <input type="text" class="form-control col-md-6" name="receiverFullName" id="receiverFullName">
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="receiverAccountNumber">Receiver's Account Number</label>
                                                                    <input type="email" class="form-control" name="receiverAccountNumber" id="receiverAccountNumber">
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="routingCode">SWIFT/ABA Routing Number</label>
                                                                    <input type="text" class="form-control" name="routingCode" id="routingCode" >
                                                                </div>

                                                                <div class="form-group col-md-12">
                                                                    <label for="amountTransfer">Amount to Transfer USD$</label>
                                                                    <input type="text" class="form-control" name="amountTransfer" id="amountTransfer">
                                                                </div>
                                                                                                                                                                                                
                                                                <div class="form-group col-md-12">
                                                                    <label for="transferDate">Date of Transfer</label>
                                                                    <div class="input-group input-group-lg">
                                                                        <input type="text" class="form-control" name="transferDate" id="transferDate">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </span>                                                                    
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="transferDescription">Transfer Description</label>
                                                                    <input type="text" class="form-control" name="transferDescription" id="transferDescription">
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <div class="col-sm-10">
                                                                        <button type="submit" class="btn btn-success">Transfer Fund</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                          <div class="alert alert-info m-t-sm m-b-lg" role="alert">
                                                          <div class="transfer-note">
                                                                <h3>Please Note</h3>
                                                                <ul>
                                                                    <li>Transactions you make on business days before 6:00pm will be preocessed by us the same day</li>

                                                                    <li>Transactions made at all other times will be processed by us the next business day.</li>

                                                                    <li>Payments to third parties (such as utility bills and non-RBC credit cards) often need 
                                                                    more processing time by the third party -- which generally takes up to 3 business days. 
                                                                    It's a good idea to check with these third parties to find out how far in advance you 
                                                                    should make the payments in order to meet their due date.</li>

                                                                    <li>Learn more about paying your bills online in the Customer Support Center</li>                                                          
                                                                    <li>Funds transfer is a process of transfering funds from your account to other account in same Bank.</li>
                                                                    <li>Please make sure that you have enough funds available in your account to transfer.</li>
                                                                    <li>Also don't forgot to validate receiver's account number.</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        </div>
                                            </div>
                                        </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- Row -->