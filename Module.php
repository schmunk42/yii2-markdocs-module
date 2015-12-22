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
     * Restrict access permissions to admin user and users with auth-item 'module-controller'
     * @inheritdoc
     */
    public function behaviors()
    {
        $modulePermission = str_replace('/', '_', $this->id);
        $moduleControllerPermission = str_replace('/', '_', $this->id . '/' . \Yii::$app->controller->id);

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function () use ($modulePermission, $moduleControllerPermission) {
                            if (!(\Yii::$app->user->can($modulePermission) || (\Yii::$app->user->identity && \Yii::$app->user->identity->isAdmin))) {
                                return \Yii::$app->user->can($moduleControllerPermission) || (\Yii::$app->user->identity && \Yii::$app->user->identity->isAdmin);
                            } else {
                                return true;
                            }
                        },
                    ]
                ]
            ]
        ];
    }

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
