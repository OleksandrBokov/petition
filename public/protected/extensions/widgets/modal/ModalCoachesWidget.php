<?php


class ModalCoachesWidget extends CWidget
{
    public $coaches = array();

    public function init()
    {
        echo $this->renderPreview();

         $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
         $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, -1, YII_DEBUG);

         $cs = Yii::app()->clientScript;

         $cs->registerScriptFile("{$baseUrl}/modal.js", CClientScript::POS_END);
            $cs->registerCssFile("{$baseUrl}/modal.css");
    }

    protected function renderPreview()
    {
        $content = '';
        $content .= CHtml::openTag('div',['class'=>'list-coaches']);
        $content .= CHtml::openTag('ul');

        foreach ($this->coaches as $item)
        {
            $data = $item->attributes;
            $data['photo'] = EntityCoach::model()->getPhoto($item);
            $data = json_encode($data);

            $content .= CHtml::openTag('li');

            $content .= CHtml::openTag('a',['class'=>'thumbnail','onclick'=>"$.fn.modalCouch.init({$data})"]);

            if($photo = EntityCoach::model()->getPhoto($item)) {
                $content .= CHtml::image($photo, $item->full_name);
            }

            $content .= CHtml::openTag('p',['class'=>'trainer-name']);
            $content .= $item->full_name;
            $content .= CHtml::closeTag('p');

            $content .= CHtml::closeTag('a');

            $content .= CHtml::closeTag('li');
        }

        $content .= CHtml::closeTag('ul');
        $content .= CHtml::closeTag('div');
        return $content;
    }
}