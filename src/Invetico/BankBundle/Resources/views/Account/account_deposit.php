

<div class="panel panel-white">
    <div class="panel-heading clearfix">
        <h4 class="panel-title align-center"><?php echo $this->pageTitle;?></h4>
    </div>
    <div class="panel-body">
        <form action="<?php echo $this->postUrl?>" method="POST">                                     
            <table class="table table-striped table-modern">
                <thead>
                    <tr>
                        <th colspan="2"><?php echo $this->account->getAccountName();?> <span class="steps"><?php echo currency($this->account->getBalance());?></span></th>
                    </tr>
                </thead>                                                
                <tbody>
                    <tr>
                    <th colspan="2" class="sub-heading">Please enter details below</th>
                    </tr>                
                    
                    <tr>
                        <td class="td-label">Amount:</td>
                        <td>
                            <input class="form-control input-sm" type="text" name="amount" value="">
                        </td>
                    </tr>
                    <tr>
                        <td class="td-label">Description:</td>
                        <td>
                            <textarea class="form-control input-md" name="description"></textarea>
                        </td>
                    </tr>                     
                                                                     
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td>
                            <div class="btn-submit-container">
                                <button class="btn btn-primary btn-medium">Submit</button>
                            </div>                            
                        </td>
                    </tr>
                </tfoot>
            </table>  
        </form>
    </div>
</div>