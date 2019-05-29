<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>

	<head>
	    <meta charset="<?= Yii::$app->charset ?>">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	     <?= Html::csrfMetaTags() ?>
	    <title><?= Html::encode($this->title) ?></title>
	    <?php $this->head() ?>
	</head>

	<body class="gray-bg">
		<?php $this->beginBody() ?>
		<?= $content ?>
		<?php $this->endBody() ?>

        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    toastr['success']("<?= Yii::$app->session->getFlash('success');?>", '');
                });
            </script>
        <?php endif; ?>
        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    toastr['error']("<?= Yii::$app->session->getFlash('error');?>", '');
                });
            </script>
        <?php endif; ?>
	</body>
</html>
<?php $this->endPage() ?>
