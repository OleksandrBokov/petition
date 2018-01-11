<?php

class SConfig extends CApplicationComponent
{
    protected $data = array();

    public function init()
    {
        //Yii::app()->config->get('....');
        $items = Config::model()->findAll();
        foreach ($items as $item){
            if ($item->param)
                $this->data[$item->param] = $item->value === '' ?  $item->default : $item->value;
        }
        parent::init();
    }

    public function get($key)
    {
        if (array_key_exists($key, $this->data)){
            return $this->data[$key];
        } else {
            throw new CException('Undefined parameter '.$key);
        }
    }

    public function set($key, $value)
    {
        $model = Config::model()->findByAttributes(array('param'=>$key));
        if (!$model)
            throw new CException('Undefined parameter '.$key);

        $this->data[$key] = $value;
        $model->value = $value;
        $model->save();
    }
}