<?php

namespace schmunk42\markdocs;

use yii\filters\AccessControl;

/**
 * Markdown parser module
 */
class Module extends \yii\base\Module
{
    public $defaultRoute = 'default/index';

    /**
     * @var string url or local alias with markdown files
     */
    public $markdownUrl = 'https://raw.githubusercontent.com/phundament/app/master/docs/';

    /**
     * @var string URL for fork link on bottom of page
     */
    public $forkUrl = 'https://github.com/phundament/app/blob/master/docs/';

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
}
