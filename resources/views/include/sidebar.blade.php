 <nav class="pcoded-navbar">
                            <div class="nav-list">
                                <div class="pcoded-inner-navbar main-menu">
                                    <!--<div class="pcoded-navigation-label">Navigation</div>-->
                                    <ul class="pcoded-item pcoded-left-item">
                                        <li class="pcoded-mtext">
                                            <a href="<?php echo URL::to('/');?>/dashboard" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                                <span class="pcoded-mtext">Dashboard</span>
                                            </a>
                                        </li>
     
                                        <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                <span class="pcoded-micon">
                                                    <i class="feather icon-layers"></i>
                                                </span>
                                                <span class="pcoded-mtext">Master</span>
											<!--    <span class="pcoded-badge label label-danger">100+</span>-->
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class="">
                                                    <a href="<?php echo URL::to('/');?>/category" class="waves-effect waves-dark">
                                                        <span class="pcoded-mtext">Category Master</span>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="<?php echo URL::to('/');?>/hotel" class="waves-effect waves-dark">
                                                        <span class="pcoded-mtext">Hotel Master</span>
                                                    </a>
                                                </li>
												<li class="">
                                                    <a href="<?php echo URL::to('/');?>/subscription" class="waves-effect waves-dark">
                                                        <span class="pcoded-mtext">Subscription Master</span>
                                                    </a>
                                                </li>
												
                                             
                                            </ul>
                                        </li>
										
                                    </ul>
                                    
                                </div>
                            </div>
                        </nav>