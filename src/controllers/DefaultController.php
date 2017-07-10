<?php
/**
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2014 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace schmunk42\markdocs\controllers;

use dmstr\web\EmojifyJsAsset;
use dmstr\web\MermaidAsset;
use yii\base\ErrorException;
use yii\helpers\Markdown;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\View;

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
    public function actionIndex($file = null)
    {

        if ($file === null) {
            $file = $this->module->defaultIndexFile;
        } else {
            if (!preg_match('/^[a-zA-Z0-9-\/]+\.md$/', $file)) {
                throw new HttpException(400,'Parameter validation failed');
            }
        }

        // TODO: DRY(!)
        $cacheKey = 'github-markdown/toc';
        $toc = \Yii::$app->cache->get($cacheKey);
        if (!$toc) {
            $toc = $this->createHtml('README.md', true);
            \Yii::$app->cache->set($cacheKey, $toc, $this->module->cachingTime);
        }
        $cacheKey = 'github-markdown/'.$file;
        $html = \Yii::$app->cache->get($cacheKey);
        if (!$html) {
            $html = $this->createHtml($file);
            \Yii::$app->cache->set($cacheKey, $html, $this->module->cachingTime);
        }

        // TODO: this is a hotfix for image URLs
        $html = str_replace('src="./', 'src="'.$this->module->markdownUrl.'/', $html);

        // exract headline - TODO: this should be done with the Markdown parser
        preg_match("/\<h[1-3]\>(.*)\<\/h[1-3]\>/", $html, $matches);
        if (isset($matches[1])) {
            $headline = $matches[1];
        } else {
            $headline = $file;
        }

        $this->registerClientScripts();

        return $this->render(
            'docs',
            [
                'html' => $html,
                'toc' => $toc,
                'headline' => $headline,
                'breadcrumbs' => explode('/', $file),
                'forkUrl' => (!empty($this->module->forkUrl)) ? $this->module->forkUrl : false,
            ]
        );
    }

    /**
     * Helper function for the docs action
     * @return string
     */
    private function createHtml($file, $useRootPath = false)
    {
        $filePath = \Yii::getAlias($this->module->markdownUrl).'/'.$file;
        \Yii::trace("Creating HTML for '{$filePath}'", __METHOD__);
        try {
            $markdown = file_get_contents($filePath);
            \Yii::trace("Loaded markdown for '{$filePath}'", __METHOD__);
        } catch (\Exception $e) {
            \Yii::$app->session->addFlash("error", "File '{$file}' not found,");
            return false;
        }

        $_slash = $useRootPath ? '' : '/';
        $html = Markdown::process($markdown, 'gfm');
        $html = preg_replace('|<a href="(?!http)'.$_slash.'(.+\.md)">|U', '<a href="__INTERNAL_URL__$1">', $html);

        $dummyUrl = Url::to(['/'.$this->module->id.'/default/index', 'file' => '__PLACEHOLDER__']);
        $html = strtr($html, ['__INTERNAL_URL__' => $dummyUrl]);
        $html = strtr($html, ['__PLACEHOLDER__' => '']);

        return $html;
    }

    private function registerClientScripts()
    {
        if ($this->module->enableEmojis) {
            EmojifyJsAsset::register($this->view);
        }
        if ($this->module->enableMermaid) {
            MermaidAsset::register($this->view);
            \Yii::$app->view->registerJs("mermaid.initialize({startOnLoad:true});");
        }
    }

}