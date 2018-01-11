<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{

    public $_assetsUrl = null;

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();


    public function init()
    {
        //$subdomain = false;

//        if(isset($_SERVER['HTTP_HOST']))
//            $parsedUrl = parse_url($_SERVER['HTTP_HOST']);

        //$host = explode(Yii::app()->config->get('defaultSiteHost'), $parsedUrl['path']);


//        if(count($host) > 1){
//            $subdomain = array_shift($host);
//        }
//
//        $subdomain = str_replace('.','',$subdomain);

        //Yii::app()->session->add('city',$subdomain);

      //  Yii::app()->session['city'] = $subdomain;
        //Yii::app()->setParams(array('city' => $subdomain));

        if (!empty($_GET['language']))
            Yii::app()->language = $_GET['language'];

        //new JsTrans('main',Yii::app()->language);

        parent::init();
    }

    /**
     * Publish admin stylesheets,images,scripts,etc.. and return assets url
     *
     * @access public
     * @return string Assets url
     */
    public function getAssetsUrl()
    {
        if( $this->_assetsUrl===null )
        {
            $this->_assetsUrl=Yii::app()->getAssetManager()->publish(
                Yii::getPathOfAlias('webroot.themes.'.Yii::app()->theme->getName().'.assets'),
                false,
                -1,
                YII_DEBUG
            );
        }
        return $this->_assetsUrl;
    }

    /**
     * Set assets url
     *
     * @param string $url
     * @access public
     * @return void
     */
    public function setAssetsUrl($url)
    {
        $this->_assetsUrl = $url;
    }


}