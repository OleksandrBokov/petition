<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
Yii::import('application.components.widgets.*');

/**
 * Class UserController
 */
class UserController extends CController
{
    /** assets in module user **/
    public $_assetsUrl = null;

    /** assets in current theme **/
    public $_themeAssetsUrl = null;

    /** language suffix needed to form **/
    public $suffix = null;

    /** path to layout in the current module **/
    public $layout='application.modules.user.views.layouts.main';

    /** @var string defaultViewPath  **/
    public $defaultViewPath = 'application.modules.user.views.';
    /**
     * @var array
     */
    public $breadcrumbs = array();

    /** link  **/
    public $prevPage = '/';

    /**
     * set sufix for language
     * and logout if role not user
     */
    public function init()
    {
        foreach (Yii::app()->params['translatedLanguages'] as $l => $lang) {
            if($l === Yii::app()->language)
                $this->suffix = '_' . $l;
            else
                $this->suffix = '';
        }

        if(Yii::app()->user->role != User::ROLE_USER){
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
                Yii::getPathOfAlias('webroot.protected.modules.user.assets'),
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
                'actions' => array('index','view','create','update','delete'),
                'roles' => array('user'),
            ),
            array(
                'allow',
                'actions' => array('login','registration'),
                'users' => array('*'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),

            ),
        );
    }

    /**
     * logout
     */
    public function logout()
    {
        Yii::app()->user->logout();
    }

    /**
     * @param $key
     * @return string
     */
    public function setInputSuffix($key)
    {
        if($key == Yii::app()->params['defaultLanguage']){
            return '';
        }else{
            return '_'.$key;
        }
    }
}