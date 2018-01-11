<?php

/**
 * @author Yaroslav Fedan <yaroslav.fd@gmail.com>
 * @link https://github.com/YaroslavFedan
 */
class SModuleUrlRulesBehavior extends CBehavior
{
    public function events()
    {
        return array_merge(parent::events(),array(
            'onBeginRequest'=>'beginRequest',
        ));
    }

    public function beginRequest($event)
    {
        $moduleName = $this->_getModuleName();

        if(Yii::app()->hasModule($moduleName))
        {
            $module = Yii::app()->getModule($moduleName);
            if(isset($module->urlRules))
            {
                $urlManager = Yii::app()->getUrlManager();
                $urlManager->addRules($module->urlRules);
            }
        }
    }

    protected function _getModuleName()
    {
        $route = Yii::app()->getRequest()->getPathInfo();
        $domains = explode('/', $route);
        $moduleName = array_shift($domains);
        return $moduleName;
    }
}