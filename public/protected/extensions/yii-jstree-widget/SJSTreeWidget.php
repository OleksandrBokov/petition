<?php

/**
 * Виджет JSTreeWidget это wrapper для javascripn библиотеки jsTree
 */
class SJSTreeWidget extends CInputWidget
{
    public $htmlOptions;

    public $settings = array('themes');
    public $events = array();

    public $customize = false;



    public function init()
    {

        if (isset($this->htmlOptions['id']))
            $id = $this->htmlOptions['id'];
        else
            $id = $this->htmlOptions['id'] = $this->getId();

        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'jstree' . DIRECTORY_SEPARATOR . 'dist';
        $assets = Yii::app()->getAssetManager()->publish($dir);
        $cs=Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($assets . '/helper/migrate.js',CClientScript::POS_END);
        $cs->registerScriptFile($assets . '/jstree.js',CClientScript::POS_END);

        Yii::app()->getClientScript()->registerPackage('cookie');


        $cs->registerCssFile($assets . '/themes/apple/style.css',CClientScript::POS_HEAD);


        $js = '$("#' . $id . '")';
        foreach($this->events as $name => $event)
        {
            $js = $js . '.on("'.$name.'", function(event){'.$event.'})';
        }
        $js = $js . '.jstree(' . CJavaScript::encode($this->settings) . ');';
        $cs->registerScript('Yii.' . get_class($this) . '#' . $id, $js);


        if($this->customize)
            $this->scriptCustomize($id);

    }


    protected function scriptCustomize($id)
    {
        $selected_Id = Yii::app()->getRequest()->getParam('id');

        $update = Yii::app()->controller->createUrl("update");//Yii::app()->createUrl("/admin/category/update"); //Yii::app()->controller->createUrl("update")
        $move = Yii::app()->controller->createUrl("move");//Yii::app()->createUrl('/admin/category/move');

        $js = '$("#' . $id . '")';

        $attribute =<<<EOP

        var treeview = {$js};

        treeview.on("__ready.jstree", function (e, data) {
            treeview.jstree('open_all');
        });
        treeview.on("load_node.jstree", function (e, data) {
            $('#{$id} li').each( function(){
                if($(this).attr("data-id") == '{$selected_Id}'){
                    $(this).children("a").addClass("jstree-clicked");
                }
            })
        });
        treeview.on("select_node.jstree", function (e, data) {
            var id = data.rslt.obj.attr("data-id");
            var url = "{$update}";
            window.location.href = url +"/id/"+id;
        });
        treeview.bind("move_node.jstree", function (e, data) {
            var parent_id = 0;
            var obj_id;
            if(data.rslt.parent.attr){
                parent_id = data.rslt.parent.attr("data-id");
            }
            obj_id = data.rslt.obj.attr("data-id");
            $.ajax({
                "type":"POST",
                "dataType":"json",
                "url":"{$move}",
                "data":{"parent_id":parent_id, "obj_id":obj_id},
               "success":function(data){treeview.jstree("open_all"); 
                console.log(data);
               }
            })
        });

EOP;
        Yii::app()->getClientScript()->registerScript('Yii.treeCustomize', $attribute );
    }

    public function run()
    {
        $html = CHtml::openTag("div", array("id" => $this->htmlOptions['id']));
        $html .= CHtml::closeTag("div");
        echo $html;
    }
}
