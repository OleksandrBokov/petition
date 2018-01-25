<?php

class SMenu extends CWidget
{
    private $_items;

    public $module;

    /**
     * Set default items
     */
    public function init()
    {
        $this->_items = array();
    }

    /**
     * Render menu
     */
    public function run()
    {

        $installedModules = Yii::app()->modules;
        $items = $this->findMenuFiles( $installedModules );

        $this->processSorting($items);

        $this->widget('application.widgets.mbmenu.MbMenu', array('items'=>$items));
    }


    protected function processSorting(&$items)
    {
        uasort($items, "SMenu::sortByPosition");
        foreach ($items as $key => $item)
        {
            if (isset($item['items']))
                $this->processSorting($items[$key]['items']);
        }
    }

    /**
     * Find and load module menu files.
     */
    protected function findMenuFiles($installedModules, &$result = array())
    {

        $moduleName = ucfirst($this->module).'Module';


        if(is_array($installedModules) )
        {

            foreach ($installedModules as $key => $value)
            {
                if($key == $this->module && !empty($value)){

                    $str = str_replace($moduleName,'config',$value['class']);

                    if(file_exists(Yii::getPathOfAlias($str))){
                        $filePath = Yii::getPathOfAlias($str).DIRECTORY_SEPARATOR.'menu.php';

                        if (file_exists($filePath))
                            $result = CMap::mergeArray($result, require($filePath));
                    }
                }

                if(isset($value['modules'][$this->module])){
                    $this->findMenuFiles($value['modules'], $result);
                }
            }
        }

        return $result;

    }
    /**
     *  Sort an array
     * @static
     * @param  $a array
     * @param  $b array
     * @return int
     */
    public static function sortByPosition($a, $b)
    {
        if (isset($a['position']) && isset($b['position']))
        {
            if ((int)$a['position'] === (int)$b['position'])
                return 0;
            return ((int)$a['position'] > (int)$b['position']) ? 1 : -1;
        }

        return 1;
    }
}