<?php
$this->title = $headline;
$this->params['breadcrumbs'][] = ['url' => ['/docs'], 'label' => 'Docs'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="docs">
    <div class="row">
        <div class="col-lg-9 col-md-8 col-xs-12 pull-right">
            <div class="file-content panel panel-body">
                <?= $html ?>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-xs-12 pull-left">
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
        ) ?> on GitHub.
    </p>
    <?php endif; ?>
</div>
