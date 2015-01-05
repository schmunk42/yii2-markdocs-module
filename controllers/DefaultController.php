<?php
/**
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2014 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace schmunk42\markdocs\controllers;

use yii\helpers\Markdown;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Class DefaultController
 * @author Tobias Munk <tobias@diemeisterei.de>
 */
class DefaultController extends Controller
{
    /**
     * Renders the documentation pages from github.com
     * @return string
     */
    public function actionIndex($file = '10-about.md')
    {
        // TOOD: DRY(!)
        $cacheKey = 'github-markdown/toc';
        $toc      = \Yii::$app->cache->get($cacheKey);
        if (!$toc) {
            $toc = $this->createHtml('README.md');
            \Yii::$app->cache->set($cacheKey, $toc, 300);
        }

        $cacheKey = 'github-markdown/' . $file;
        $html     = \Yii::$app->cache->get($cacheKey);
        if (!$html) {
            $html = $this->createHtml($file);
            \Yii::$app->cache->set($cacheKey, $html, 300);
        }

        #$this->layout = 'container';
        return $this->render(
            'docs',
            [
                'html'     => $html,
                'toc'      => $toc,
                'headline' => $file,
                'forkUrl'  => 'https://github.com/phundament/app/blob/master/docs/' . $file
            ]
        );
    }

    /**
     * Helper function for the docs action
     * @return string
     */
    private function createHtml($file)
    {
        \Yii::trace("Creating HTML for '{$file}'", __METHOD__);
        $markdown = file_get_contents('https://raw.githubusercontent.com/phundament/app/master/docs/' . $file);
        $html     = Markdown::process($markdown, 'gfm');
        $html     = preg_replace('/<a href="(?!http)(.+\.md)">/U', '<a href="__INTERNAL_URL__$1">', $html);

        $dummyUrl = Url::to(['/docs', 'file' => '__PLACEHOLDER__']);
        $html     = strtr($html, ['__INTERNAL_URL__' => $dummyUrl]);
        $html     = strtr($html, ['__PLACEHOLDER__' => '']);

        return $html;
    }

}