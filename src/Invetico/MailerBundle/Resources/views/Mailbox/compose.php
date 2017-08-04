                    <div class="row m-t-md">
                        <div class="col-md-12">
                            <div class="row mailbox-header">
                                <div class="col-md-2">
                                    <a href="[link route_name=mailbox_inbox]" class="btn btn-success btn-block">Back to Inbox</a>
                                </div>
                                <div class="col-md-6">
                                    <h2>Compose</h2>
                                </div>
                                <div class="col-md-4">
                                    <div class="compose-options">
                                        <div class="pull-right">
                                            <a href="inbox.html" class="btn btn-default"><i class="fa fa-file-text-o m-r-xs"></i>Draft</a>
                                            <a href="inbox.html" class="btn btn-danger"><i class="fa fa-trash m-r-xs"></i>Discard</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <ul class="list-unstyled mailbox-nav">
                                <li><a href="inbox.html"><i class="fa fa-inbox"></i>Inbox <span class="badge badge-success pull-right">4</span></a></li>
                                <li><a href="#"><i class="fa fa-sign-out"></i>Sent</a></li>
                                <li><a href="#"><i class="fa fa-file-text-o"></i>Draft</a></li>
                                <li><a href="#"><i class="fa fa-exclamation-circle"></i>Spam</a></li>
                                <li><a href="#"><i class="fa fa-trash"></i>Trash</a></li>
                            </ul>
                        </div>
                        <div class="col-md-10">
                            <div class="mailbox-content">
                                <div class="compose-body">
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <label for="to" class="col-sm-2 control-label">To</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="to">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="subject" class="col-sm-2 control-label">Subject</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="subject">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="compose-message">
                                    <div class="summernote"></div>
                                </div>
                                <div class="compose-options">
                                    <div class="pull-right">
                                        <a href="inbox.html" class="btn btn-success"><i class="fa fa-send m-r-xs"></i>Send</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- Row -->