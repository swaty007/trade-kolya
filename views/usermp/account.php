<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

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

<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-sm-4">
                <nav>
                    <?php echo $menu; ?>
                </nav>
            </div>
            <div class="col-sm-8">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">Остатки по счету</a></li>
                    <li><a data-toggle="tab" href="#menu1">Задачи</a></li>
                    <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
                </ul>

                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <div class="panel panel-default">
                            <!--div class="panel-heading">Заголовок</div -->
                            <div class="panel-body">
                                <table class="table-bordered table-hover table table-striped">
                                    <thead>
                                        <tr>
                                            <td>Назввание</td>
                                            <td>available</td>
                                            <td>onOrder</td>
                                            <td>btcValue</td>
                                            <td>btcTotal</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($state as $key => $value) { ?>
                                            <tr>
                                                <td><?php echo $key; ?></td>
                                                <td><?php echo $value['available']; ?></td>
                                                <td><?php echo $value['onOrder']; ?></td>
                                                <td><?php echo $value['btcValue']; ?></td>
                                                <td><?php echo $value['btcTotal']; ?></td>
                                            </tr>                        
                                        <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <h3>Задачи</h3>
                        <div class="panel-body">
                            <table class="table-bordered table-hover table table-striped">
                                <thead>
                                    <tr>
                                        <td>Задача</td>
                                        <td>Валюта</td>
                                        <td>Статус</td>
                                        <td>Условие</td>
                                        <td>Редактировать</td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                        </div>

                        <button data-toggle="collapse" data-target="#TaskAdd">Добавить</button>

                        <div id="TaskAdd" class="collapse">
                            <form action="<?php echo $formActionTaskAdd; ?>">
                                <div class="form-group">
                                    <label for="task">Задача:</label>
                                    <label class="radio-inline"><input type="radio" name="task" value="buy" required> Купить</label>
                                    <label class="radio-inline"><input type="radio" name="task" value="sell"> Продать</label>
                                </div>
                                <div class="form-group">
                                    <label for="currency_id">Валюта:</label>
                                    <select name="currency_id" class="form-control" required>
                                        <?php foreach ($currency as $code => $value) { ?>
                                            <option value="<?php echo $code ?>"><?php echo $value['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="count">Количество:</label>
                                    <input type="number" name="count" step="0.01" min="0" class="form-control" id="count" required>
                                </div>
                                <button type="submit" class="btn btn-default">Добавить</button>
                            </form> 
                        </div> 

                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <h3>Menu 2</h3>
                        <p>Some content in menu 2.</p>
                    </div>
                </div>
                <?php //print_r($state); ?>
                <!--h2>Остатки по счету</h2-->

            </div>

        </div>
    </div>
</div>