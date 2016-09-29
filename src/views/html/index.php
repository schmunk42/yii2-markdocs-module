<?php
$this->title = $headline;
$this->params['breadcrumbs'][] = ['url' => ['/docs'], 'label' => 'Docs'];
$this->params['breadcrumbs'][] = ['url' => ['/docs/html/index', 'file'=>'index'], 'label' => 'API'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="docs">
    <div class="row">
        <div class="col-xs-12">
            <div class="file-content panel panel-body">
                <?= $html ?>
            </div>
        </div>
    </div>
</div>
