<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->title = 'My Yii Application';
?>
<style type="text/css">
      body {
        margin: 0px;
        padding: 0px;
      }
      #container {
        width : 600px;
        height: 384px;
        margin: 8px auto;
      }
      .graf {
        width : 600px;
        height: 384px;
        margin: 8px auto;
      }
    </style>

<div class="row wrapper border-bottom white-bg">
    <div class="col-lg-10">
        <h2>Take Profit</h2>
    </div>
    <div class="col-lg-10">
        <h3>Личный кабинет</h3>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">     
    <div class="row">
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Меню</h5>
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
                    <nav>
                        <?php echo $menu; ?>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Таблица аккаунтов бирж</h5>
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
                    <div data-course data-marketplace_id="<?php echo $marketplace_id; ?>">
                        <div class="currency">
                            <select name="currency[0]">
                                <option value="">валюта 1</option>
                                <?php foreach ($currency as $code => $value) { ?>
                                <option value="<?php echo $code?>"><?php echo $value['name']; ?></option>
                                <?php } ?>
                            </select>
                            <select name="currency[1]">
                                <option value="">валюта 2</option>
                                <?php foreach ($currency as $code => $value) { ?>
                                <option value="<?php echo $code?>"><?php echo $value['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="graf"></div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
