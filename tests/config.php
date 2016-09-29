<?php
/**
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


return [
    'aliases' => [
        '@schmunk42/markdocs' => '@vendor/schmunk42/yii2-markdocs-module/src'
    ],
    'components' => [
        'cache' => '\yii\caching\DummyCache',
        'urlManager' => [
            'rules' => [
                'api/<file:[a-zA-Z0-9_\-\./\+]*>.html' => 'markdocs/html/index',
                'api/<file:[a-zA-Z0-9_\-\./\+]*>' => 'markdocs/html/index',
            ]
        ]
    ],
    'modules' => [
        'markdocs' => [
            'class' => 'schmunk42\markdocs\Module',
            'markdownUrl' => 'https://raw.githubusercontent.com/dmstr/docs-phd5/master/help',
            'htmlUrl' => 'http://docs.phundament.com/5.0.0-beta3'
        ]
    ]
];