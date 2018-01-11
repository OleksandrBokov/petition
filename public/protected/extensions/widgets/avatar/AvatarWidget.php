<?php

class AvatarWidget extends CWidget
{


    protected $default = array();

    public $image;
    public $color = false;

    public function init()
    {

        $bgColor = ($this->color) ? $this->color : '#'.$this->randomColor();// $this->randomColor();//$this->color

        $defImg = array(
            'src'=>false,
            'alt'=>false,
            'base_url'=>false,
            'upload'=>false,
            'htmlOptions'=>array(
                'style'=>'width:65px;  
                          height:65px;  
                          border-radius: 65px;  
                          position:relative;
                          background-color:'.$bgColor
            ),
            'itemOptions'=>array(
                'style'=>'position: absolute;
                          text-align: center;
                          margin-left: auto;
                          margin-right: auto;
                          width: 100%;
                          text-transform: uppercase;
                          color: rgba(255, 255,255, 0.8);'
            )
        );
        
        if(!isset($this->image['htmlOptions'])){
            $this->image['htmlOptions'] = $defImg['htmlOptions'];
        }else{
            $this->image['htmlOptions']['style'] ='background-color:'.$bgColor.';position:relative;';
        }

        if(!isset($this->image['itemOptions'])){
            $defImg['itemOptions']['style'] .= 'font-size: 25px; line-height: 60px;';
            $this->image['itemOptions'] = $defImg['itemOptions'];
        }else{
            $this->image['itemOptions']['style'] .= $defImg['itemOptions']['style'];
        }

//        echo "<pre>";
//        print_r( $this->image );
//        echo "</pre>";

        echo $this->renderImage($this->image);
    }

    public function renderImage($image)
    {
        $content = '';
        if(!empty($image['src']))
        {
            $content .= CHtml::image($image['base_url'].$image['src'], $image['alt'], $image['htmlOptions']);
        }elseif(!empty($image['alt']) && !$image['upload'])
        {
            $content .= $this->generateName($image);
        }elseif($image['upload'])
        {

            $content .= $this->uploadAvatar($content);
        }

        return $content;
    }

    /**
     * @param $image
     * @return string
     *
     * preg_replace('/(\w+) (\w)\w+ (\w)\w+/iu', '$1 $2. $3.', 'First Last Name'); -> First L. N.
     *
     * preg_replace('/(\w)\w+ (\w)\w+ (\w)\w+/iu', '$1. $2. $3.', 'First Last Name'); -> F. L. N.
     * preg_replace('/(\w)\w+ (\w)\w+ (\w)\w+/iu', '$1$2$3', 'First Last Name'); -> FLN
     */
    protected function generateName($image)
    {
        $res = '';

        if(!empty($image['alt']))
        {
            $arr = explode(' ',$image['alt']);
            $cnt = count($arr);
            $str='';
            switch ($cnt){
                case 2: $str .= mb_substr($arr[1],0,1,"UTF-8");
                case 1: $str .= mb_substr($arr[0],0,1,"UTF-8");break;
            }

            $res .= CHtml::openTag('div',$image['htmlOptions']);
            $res .= CHtml::openTag('span', $image['itemOptions']);
            $res .= $str;
            $res .= CHtml::closeTag('span');
            $res .= CHtml::closeTag('div');

        }
        return $res;
    }



    protected function randomColorPart() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    protected function randomColor() {
        return $this->randomColorPart() . $this->randomColorPart() . $this->randomColorPart();
    }


}