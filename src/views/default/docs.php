<?php
/* @var $this \yii\web\View */

use yii\helpers\Url;

$this->title = $headline;

$indexUrl = Url::to(['/docs/default/index','schema' => $schema ]);

$this->params['breadcrumbs'][] = ['url' => ['/docs'], 'label' => $this->context->module->id];
$this->params['breadcrumbs'][] = ['url' => $indexUrl, 'label' => $label];
$this->params['breadcrumbs'][] = ['label' => ucfirst($breadcrumbs[0])];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="docs">
    <div class="row">
        <div class="col-lg-9 col-md-8 col-xs-12 pull-right">
            <div class="file-content panel">

            <div class="panel-body">
                <?= $html ?>
            </div>
            <div class="panel-footer">
                <p class="text-muted small">
                    Generated from <code><?= $file ?></code>
                </p>
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
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-xs-12 pull-left">
            <div class="toc panel panel-body">
                <?= $toc ?>


            </div>
        </div>
    </div>

</div>
