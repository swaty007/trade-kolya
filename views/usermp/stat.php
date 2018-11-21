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

<?php 
foreach ($marketplaces as $marketplace) {
?>
        <div class="ibox">
            <div class="ibox-title">
                <h5><?php echo $marketplace['name']?></h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#" class="dropdown-item">Config option 1</a>
                        </li>
                        <li><a href="#" class="dropdown-item">Config option 2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content" style="">
                <div class="row">
                    <div class="col-lg-4">
                        <div id="user_marketplace_id_<?php echo $marketplace['user_marketplace_id']; ?>" style="width : 100%;height: 384px;margin: 8px auto;">
                            
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <?php foreach ($marketplace['balance'] as $key => $value) { ?>
                          <div><?php echo $key; ?>: <?php echo $value['available']; ?></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
<?php } ?>
<script>
    
    var flotr_data = <?php echo json_encode($flotr_data); ?>;
    //console.dir(flotr_data);
</script>

<?php
print_r($marketplaces);
?>