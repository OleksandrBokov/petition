<?php

class LTEBreadcrumbs extends CWidget
{
    public $items = array();
    public $titlePage;


    public function init()
    {
//        echo "<pre>";
//        print_r($this->titlePage);
//        echo "</pre>";
//        echo "<pre>";
//        print_r($this->items);
//        echo "</pre>";
//        die;
        if(!empty($this->titlePage))
            $this->setTitlePage();
        if(!empty($this->items))
            $this->createBreadcrumbs();

    }

    public function setTitlePage()
    {
        echo "<h1>".$this->titlePage."</h1>";
    }

    public function  createBreadcrumbs()
    {
        echo "<ol class='breadcrumb'>";
        foreach($this->items as $item)
        {
           if(!empty($item['icon'])){
               if(!empty($item['url'])){
                   echo "<li><a href='".$item['url']."'><i class='".$item['icon']."'></i> ".$item['label']."</a></li>";
               }else{
                   echo "<li class='active'>".$item['label']."</li>";
               }

           }else{
               echo "<li ><a href='".$item['url']."'>".$item['label']."</a></li>";
           }
        }
        echo "</ol>";
    }
}