<?php

/* @var $this \yii\web\View */

$this->title = $headline;
$this->params['breadcrumbs'][] = ['url' => ['/docs'], 'label' => 'Docs'];
$this->params['breadcrumbs'][] = ['url' => ['/docs/default/index'], 'label' => 'Guide'];
$this->params['breadcrumbs'][] = ['label' => ucfirst($breadcrumbs[0])];
$this->params['breadcrumbs'][] = $this->title;

// TODO: use npm-package; this is a patched (hotfixed) version
$js = Yii::$app->assetManager->publish('@schmunk42/markdocs/assets/toc-1.4.0-p1.js');
$css = Yii::$app->assetManager->publish('@schmunk42/markdocs/assets/toc.css');
$this->registerJsFile($js[1], ['depends'=>\yii\web\JqueryAsset::class]);
$this->registerCssFile($css[1]);
?>

<div class="docs">
    <div class="row">
        <div class="col-lg-2 col-md-3 col-xs-12 pull-right">
            <div class="toc-file panel panel-body" >
                <div class="well"  data-toc="h2, h3"  data-toc-container="#fc"></div>
            </div>
        </div>
        <div class="col-lg-7 col-md-6 col-xs-12 pull-right">
            <div id="fc" class="file-content panel panel-body">
                <?= $html ?>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-xs-12 pull-left">
            <div class="toc panel panel-body">
                <?= $toc ?>
            </div>
        </div>
    </div>
    <?php if ($forkUrl): ?>
        <p class="text-muted text-right small">
            <br/><br/>
            Help us to improve the documentation, <?= \yii\helpers\Html::a(
                'fork this page',
                $forkUrl,
                ['target' => '_blank']
            ) ?>.
        </p>
    <?php endif; ?>
</div>
