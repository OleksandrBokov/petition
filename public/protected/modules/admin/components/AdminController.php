<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
Yii::import('application.components.widgets.*');
class AdminController extends CController
{
    /** assets in module admin **/
    public $_assetsUrl = null;

    /** assets in current theme **/
    public $_themeAssetsUrl = null;

    /** language suffix needed to form **/
    public $suffix = null;

    /** path to layout in the current module **/
    public $layout='application.modules.admin.views.layouts.main';

    /** @var string defaultViewPath  **/
    public $defaultViewPath = 'application.modules.admin.views.';

    public $breadcrumbs = array();

    /** link  **/
    public $prevPage = '/';

    public function init()
    {
        foreach (Yii::app()->params['translatedLanguages'] as $l => $lang) {
            if($l === Yii::app()->language)
                $this->suffix = '_' . $l;
            else
                $this->suffix = '';
        }

        if(Yii::app()->user->role != User::ROLE_ADMIN){
            $this->logout();
        }
    }

    /*** path to assets in module admin ***/
    /***
     * @return null
     */
    public function getAssetsUrl()
    {

        if($this->_assetsUrl===null )
        {
            $this->_assetsUrl=Yii::app()->getAssetManager()->publish(
                Yii::getPathOfAlias('webroot.protected.modules.admin.assets'),
                false,
                -1,
                YII_DEBUG
            );
        }

        return $this->_assetsUrl;
    }



    /*** path to assets in current theme ***/
    /***
     * @return null
     */
    public function getThemeAssetsUrl()
    {
        if($this->_themeAssetsUrl===null )
        {
            $this->_themeAssetsUrl=Yii::app()->getAssetManager()->publish(
                Yii::getPathOfAlias('webroot.themes.'.Yii::app()->theme->getName().'.assets'),
                false,
                -1,
                YII_DEBUG
            );
        }
        return $this->_themeAssetsUrl;
    }


    /**
     * @param $url
     */
    public function setAssetsUrl($url)
    {
        $this->_assetsUrl = $url;
        $this->_themeAssetsUrl = $url;
    }


    /*** Default filter ***/
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            //'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /*** Default accessRules ***/
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('index','view','create','update','delete', 'settings', 'link'),
                'roles' => array('administrator'),
            ),
            array(
                'allow',
                'actions' => array('login'),
                'users' => array('*'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),

            ),
        );
    }

    public function logout()
    {
        Yii::app()->user->logout();
    }


    public function setInputSuffix($key)
    {
        if($key == Yii::app()->params['defaultLanguage']){
            return '';
        }else{
            return '_'.$key;
        }
    }
}