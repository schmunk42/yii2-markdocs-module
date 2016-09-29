<?php
/**
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace schmunk42\markdocs\controllers;

use yii\helpers\Inflector;
use yii\web\Controller;
use yii\web\HttpException;

class HtmlController extends Controller
{
    public function actionIndex($file)
    {
        if (!preg_match('/^[a-zA-Z0-9-_]+$/', $file)) {
            throw new HttpException(400, 'Parameter validation failed');
        }
        $html = file_get_contents(\Yii::getAlias($this->module->htmlUrl."/{$file}.html"));
        return $this->render(
            'index',
            [
                'html' => $html,
                'headline' => Inflector::camel2words($file)
            ]
        );
    }
}