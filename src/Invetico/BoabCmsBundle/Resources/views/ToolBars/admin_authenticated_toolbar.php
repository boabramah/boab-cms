

                 <ul class="nav navbar-nav navbar-right">
                                <li>    
                                    <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown"><i class="fa fa-envelope"></i><span class="badge badge-success pull-right">4</span></a>

                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown"><i class="fa fa-bell"></i><span class="badge badge-success pull-right">3</span></a>
                      
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                                        <span class="user-name"><?php echo $this->user->getLastName();?><i class="fa fa-angle-down"></i></span>
                                        <img class="img-circle avatar" src="<?php echo BASE_URL.$this->user->getDefaultThumbnailPath();?>" width="40" height="40" alt="">
                                    </a>
                                    <ul class="dropdown-menu dropdown-list" role="menu">
                                        <li role="presentation"><a href="<?php echo $this->router->generate('account_settings_profile');?>"><i class="fa fa-user"></i>Profile</a></li>
                                        <li role="presentation"><a href="<?php echo $this->router->generate('account_settings_password');?>"><i class="fa fa-lock"></i>Password</a></li>
                                        <li role="presentation"><a href="#"><i class="fa fa-envelope"></i>Inbox<span class="badge badge-success pull-right">4</span></a></li>
                                        <li role="presentation" class="divider"></li>
                                        <li role="presentation"><a href="<?php echo $this->router->generate('_logout');?>"><i class="fa fa-sign-out m-r-xs"></i>Log out</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="<?php echo $this->router->generate('_logout');?>" class="log-out waves-effect waves-button waves-classic">
                                        <span><i class="fa fa-sign-out m-r-xs"></i>Log out</span>
                                    </a>
                                </li>
                </ul><!-- Nav -->                