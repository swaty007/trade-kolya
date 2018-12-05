<?php
namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "css/bootstrap.min.css",
        "css/font-awesome.min.css",
        "css/plugins/datapicker/datepicker3.css",
        'css/plugins/toastr/toastr.min.css',
        "css/plugins/dataTables/dataTables.bootstrap.css",
        "css/plugins/dataTables/dataTables.responsive.css",
        "css/plugins/chosen/chosen.css",
        'js/plugins/gritter/jquery.gritter.css',
        "css/animate.css",
        "css/style.min.css",
        "js/select2/dist/css/select2.min.css",
        "css/main.css",
        "js/plugins/bootstrap-tags/bootstrap-tagsinput.css",
        "css/plugins/summernote/summernote.css",
        "css/plugins/summernote/summernote-bs3.css",
    ];
    public $js = [
        "js/plugins/jquery-ui/jquery-ui.min.js",
        'js/bootstrap.min.js',
        "js/plugins/metisMenu/jquery.metisMenu.js",
        "js/plugins/slimscroll/jquery.slimscroll.min.js",
        "js/plugins/flot/jquery.flot.js",
        "js/plugins/flot/jquery.flot.tooltip.min.js",
        "js/plugins/flot/jquery.flot.spline.js",
        "js/plugins/flot/jquery.flot.resize.js",
        "js/plugins/flot/jquery.flot.pie.js",
        "js/plugins/peity/jquery.peity.min.js",
        "js/inspinia.js",
        //"js/plugins/pace/pace.min.js",
        "js/plugins/gritter/jquery.gritter.min.js",
        "js/plugins/sparkline/jquery.sparkline.min.js",
        "js/plugins/chartJs/Chart.min.js",
        "js/plugins/toastr/toastr.min.js",
        "js/select2/dist/js/select2.full.min.js",
        "js/plugins/datapicker/bootstrap-datepicker.js",
        "js/plugins/dataTables/jquery.dataTables.js",
        "js/plugins/dataTables/dataTables.bootstrap.js",
        "js/plugins/summernote/summernote.min.js",
        "js/plugins/chosen/chosen.jquery.js",
        "js/plugins/bootstrap-tags/bootstrap3-typeahead.min.js",
        "js/plugins/bootstrap-tags/bootstrap-tagsinput.js",
        "js/global.js",
        "js/coins.js",
        "js/pool.js",
        "js/informer2.js",
        "js/market.js",
    ];
//    public $jsOptions = array(
//        'position' => \yii\web\View::POS_HEAD
//    );
    public $depends = [
       'yii\web\YiiAsset',
    ];
}
