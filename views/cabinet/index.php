<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->title = 'My Yii Application';
?>
<div class="row wrapper border-bottom white-bg">
    <div class="col-lg-10">
        <h2>Take Profit</h2>
    </div>
    <div class="col-lg-10">
        <h3>Личный кабинет</h3>
    </div>
</div>    
                
<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>New data for the report</h5> <span class="label label-primary">IN+</span>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#">Config option 1</a>
                                    </li>
                                    <li><a href="#">Config option 2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div>

                                <div class="pull-right text-right">

                                    <span class="bar_dashboard">5,3,9,6,5,9,7,3,5,2,4,7,3,2,7,9,6,4,5,7,3,2,1,0,9,5,6,8,3,2,1</span>
                                    <br/>
                                    <small class="font-bold">$ 20 054.43</small>
                                </div>
                                <h4>NYS report new data!
                                    <br/>
                                    <small class="m-r"><a href="graph_flot.html"> Check the stock price! </a> </small>
                                </h4>
                                </div>
                            </div>
                        </div>
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Read below comments and tweets</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#">Config option 1</a>
                                    </li>
                                    <li><a href="#">Config option 2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content no-padding">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <p><a class="text-info" href="#">@Alan Marry</a> I belive that. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 1 minuts ago</small>
                                </li>
                                <li class="list-group-item">
                                    <p><a class="text-info" href="#">@Stock Man</a> Check this stock chart. This price is crazy! </p>
                                    <div class="text-center m">
                                        <span id="sparkline8"></span>
                                    </div>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 2 hours ago</small>
                                </li>
                                <li class="list-group-item">
                                    <p><a class="text-info" href="#">@Kevin Smith</a> Lorem ipsum unknown printer took a galley </p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 2 minuts ago</small>
                                </li>
                                <li class="list-group-item ">
                                    <p><a class="text-info" href="#">@Jonathan Febrick</a> The standard chunk of Lorem Ipsum</p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 1 hour ago</small>
                                </li>
                                <li class="list-group-item">
                                    <p><a class="text-info" href="#">@Alan Marry</a> I belive that. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 1 minuts ago</small>
                                </li>
                                <li class="list-group-item">
                                    <p><a class="text-info" href="#">@Kevin Smith</a> Lorem ipsum unknown printer took a galley </p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 2 minuts ago</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <div>
                <strong>Copyright</strong> &copy; TakeProfit <?= date('Y') ?>
            </div>
        </div>
    </div>
</div>

   
<!-- <div class="site-index"> -->
    
    <!--div class="jumbotron"-->
        <!--h1>Take Profit</h1-- >

        <!-- <p class="lead">Личный кабинет</p -->

        <!--p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p-->
    <!--/div-->

 <!--    <div class="body-content">

        <div class="row">
            <div class="col-sm-4">
                <nav>
                <?php echo $menu; ?>
                </nav>
            </div>
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-sm-8">
                        <h4>Crypto portfolio / Bittrex</h4>
                        <img src="/image/temp/crypto1.jpg" width="100%">
                    </div>
                    <div class="col-sm-4">
                        <h4>Exchange value / Bittrex</h4>
                        <table class="table table-bordered table-hover">
                            <tr>
                                <td>Daily</td>
                                <td>1500</td>
                            </tr>
                            <tr>
                                <td>Weakly</td>
                                <td>10500</td>
                            </tr>
                            <tr>
                                <td>Monthly</td>
                                <td>1050500</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 padding-0">
                        <div class="gray-block">
                        <h4>Start Trading</h4>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.
                        <div><button class="btn btn-primary">Button</button></div>
                        </div>
                    </div>
                    <div class="col-sm-4 padding-0">
                        <div class="gray-block">
                        <h4>Use Smart Trading</h4>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.
                        <div><button class="btn btn-primary">Button</button></div>
                        </div>
                    </div>
                    <div class="col-sm-4 padding-0">
                        <div class="gray-block">
                        <h4>Portfolio Analysis</h4>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.
                        <div><button class="btn btn-primary">Button</button></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <img src="/image/temp/crypto2.jpg" width="100%">
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <table class="table table-hover table-bordered table-striped">                            
                        <thead>
                            <tr>
                                <th>Trader</th>
                                <th>Profit</th>
                                <th>Risk level</th>
                                <th>Weekly shifting</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Mr. Smith</td>
                                <td>+20%</td>
                                <td>4</td>
                                <td>-2%</td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Mr. Smith</td>
                                <td>+20%</td>
                                <td>4</td>
                                <td>-2%</td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Mr. Smith</td>
                                <td>+20%</td>
                                <td>4</td>
                                <td>-2%</td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Mr. Smith</td>
                                <td>+20%</td>
                                <td>4</td>
                                <td>-2%</td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Mr. Smith</td>
                                <td>+20%</td>
                                <td>4</td>
                                <td>-2%</td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Mr. Smith</td>
                                <td>+20%</td>
                                <td>4</td>
                                <td>-2%</td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Mr. Smith</td>
                                <td>+20%</td>
                                <td>4</td>
                                <td>-2%</td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Mr. Smith</td>
                                <td>+20%</td>
                                <td>4</td>
                                <td>-2%</td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Mr. Smith</td>
                                <td>+20%</td>
                                <td>4</td>
                                <td>-2%</td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Mr. Smith</td>
                                <td>+20%</td>
                                <td>4</td>
                                <td>-2%</td>
                            </tr>
                        </tbody>
                        
                        </table>
                        <button class="btn btn-primary">View all</button>
                    </div>
                    <div class="col-sm-6">
                                                <table class="table table-hover table-bordered table-striped">                            
                        <thead>
                            <tr>
                                <th>Channels</th>
                                <th>Followes</th>
                                <th>Risk level</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="glyphicon glyphicon glyphicon-file" aria-hidden="true"></span> Mr. Smith</td>
                                <td>123</td>
                                <td>4</td>
                                <td><span class="glyphicon glyphicon glyphicon glyphicon-eye-open" aria-hidden="true"></span></td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon glyphicon-file" aria-hidden="true"></span> Mr. Smith</td>
                                <td>123</td>
                                <td>4</td>
                                <td><span class="glyphicon glyphicon glyphicon glyphicon-eye-open" aria-hidden="true"></span></td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon glyphicon-file" aria-hidden="true"></span> Mr. Smith</td>
                                <td>123</td>
                                <td>4</td>
                                <td><span class="glyphicon glyphicon glyphicon glyphicon-eye-open" aria-hidden="true"></span></td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon glyphicon-file" aria-hidden="true"></span> Mr. Smith</td>
                                <td>123</td>
                                <td>4</td>
                                <td><span class="glyphicon glyphicon glyphicon glyphicon-eye-open" aria-hidden="true"></span></td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon glyphicon-file" aria-hidden="true"></span> Mr. Smith</td>
                                <td>123</td>
                                <td>4</td>
                                <td><span class="glyphicon glyphicon glyphicon glyphicon-eye-open" aria-hidden="true"></span></td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon glyphicon-file" aria-hidden="true"></span> Mr. Smith</td>
                                <td>123</td>
                                <td>4</td>
                                <td><span class="glyphicon glyphicon glyphicon glyphicon-eye-open" aria-hidden="true"></span></td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon glyphicon-file" aria-hidden="true"></span> Mr. Smith</td>
                                <td>123</td>
                                <td>4</td>
                                <td><span class="glyphicon glyphicon glyphicon glyphicon-eye-open" aria-hidden="true"></span></td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon glyphicon-file" aria-hidden="true"></span> Mr. Smith</td>
                                <td>123</td>
                                <td>4</td>
                                <td><span class="glyphicon glyphicon glyphicon glyphicon-eye-open" aria-hidden="true"></span></td>
                            </tr>
                        </tbody>
                        
                        </table>
                        <button class="btn btn-primary">View all</button>
                    </div>
                </div>
                
            </div>
            
        </div> -->
<!--     </div>
</div> -->