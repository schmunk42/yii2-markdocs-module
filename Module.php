<?php

namespace schmunk42\markdocs;

use yii\filters\AccessControl;

/**
 * Markdown parser module
 */
class Module extends \yii\base\Module
{
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
     * @var integer value in seconds, how long to cache generated HTML
     */
    public $cachingTime = 1;

    /**
     * Restrict access permissions to admin user and users with auth-item 'module[_controller[_action]]'
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return \Yii::$app->user->can(
                                $this->id.'_'.\Yii::$app->controller->id.'_'.$action->id,
                                ['route' => true]
                            );
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * Try configuration from settings module, if a value is not set
     */
    public function init()
    {
        parent::init();
        if (\Yii::$app->has('settings')) {
            $properties = ['markdownUrl', 'forkUrl', 'defaultIndexFile', 'cachingTime'];
            $section = str_replace('\\', '.', __NAMESPACE__);
            foreach ($properties as $property) {
                if ($this->$property === null) {
                    $this->$property = \Yii::$app->settings->get($property, $section);
                }
            }
        }
    }
}
