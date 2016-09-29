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
                'api/<file:[a-zA-Z0-9_\-\./\+]*>.html' => 'markdocs/api/index',
                'api/<file:[a-zA-Z0-9_\-\./\+]*>' => 'markdocs/api/index',
            ]
        ]
    ],
    'modules' => [
        'markdocs' => [
            'class' => 'schmunk42\markdocs\Module',
            'markdownUrl' => 'https://raw.githubusercontent.com/dmstr/docs-phd5/master/help',
            'apiHtmlUrl' => 'https://raw.githubusercontent.com/Qti3e/Impress-full/master'
        ]
    ]
];