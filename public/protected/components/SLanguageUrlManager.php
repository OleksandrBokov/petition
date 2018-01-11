<?php

class SLanguageUrlManager extends CUrlManager
{
    public function createUrl($route, $params=array(), $ampersand='&')
    {
        /** rules to add camelCase
        $route = preg_replace_callback('/(?<![A-Z])[A-Z]/', function($matches) {
            return '-' . lcfirst($matches[0]);
        }, $route);

         **/
        $url = parent::createUrl($route, $params, $ampersand);
        return SMultilangHelper::addLangToUrl($url);
    }

    /** function to add camelCase
    public function parseUrl($request)
    {
        $route = parent::parseUrl($request);
        return lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $route))));
    }**/
}