<?php

namespace schmunk42\markdocs\components;

use yii\base\BaseObject;
use yii\web\UrlRule;
use yii\web\UrlRuleInterface;

class DocsUrlRule extends BaseObject implements UrlRuleInterface
{
    public $module;
    public $suffix = '.md';

    public function createUrl($manager, $route, $params)
    {
        if (isset($params['schema']) && isset($params['file'])) {
            if ($route == $this->module . '/default/index') {
                return "{$this->module}/{$params['schema']}/{$params['file']}"; // this rule does not apply
            }
        } else {
            return false; // this rule does not apply
        }
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        preg_match(
            '%^(' . $this->module . ')/([a-zA-Z0-9\-]*)/(.*)$%',
            $pathInfo,
            $matches);
        if (isset($matches[3])) {
            return [$this->module . '/default/index', ['schema' => $matches[2], 'file' => $matches[3]]];
        }

        return false; // this rule does not apply
    }
}