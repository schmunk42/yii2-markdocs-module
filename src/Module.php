<?php

namespace schmunk42\markdocs;

use yii\filters\AccessControl;
use dmstr\web\traits\AccessBehaviorTrait;

/**
 * Markdown parser module
 */
class Module extends \yii\base\Module
{

    /**
     * Restrict access permissions to admin user and users with auth-item 'module[_controller[_action]]'
     * @inheritdoc
     */
    use AccessBehaviorTrait;

    /**
     * @inheritdoc
     */
    public $defaultRoute = 'default/index';

    /**
     * @var string url or local alias with markdown files
     */
    public $markdownUrl = null;

    /**
     * @var string default markdown index file
     */
    public $defaultIndexFile = null;

    /**
     * @var string URL for fork link on bottom of page
     */
    public $forkUrl = null;

    /**
     * @var string 
     */
    public $htmlUrl = null;

    /**
     * @var integer value in seconds, how long to cache generated HTML
     */
    public $cachingTime = 1;

    /**
     * @var bool whether to convert emoji syntax to images
     */
    public $enableEmojis = false;

    /**
     * @var bool whether to convert emoji syntax to images
     */
    public $enableMermaid = false;


    /**
     * Try configuration from settings module, if a value is not set
     */
    public function init()
    {
        parent::init();
        if (\Yii::$app->has('settings')) {
            $properties = ['markdownUrl', 'forkUrl', 'defaultIndexFile', 'cachingTime', 'htmlUrl'];
            $section = $this->id;
            $prefix = '';

            if (\Yii::$app->request->get('schema')) {
                $prefix = \Yii::$app->request->get('schema').'.';
            }

            foreach ($properties as $property) {
                if ($this->$property === null) {
                    $this->$property = \Yii::$app->settings->get($prefix.$property, $section);
                }
            }
        }
    }
}
