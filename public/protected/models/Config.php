<?php
/**
 * This is the model class for table "{{config}}".
 *
 * The followings are the available columns in table '{{config}}':
 * @property string $id
 * @property string $param
 * @property string $value
 * @property string $default
 * @property string $label
 * @property string $type
 */
class Config extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**** Кеширование конфигурации ****/
    protected function beforeFind() {
        $this->cache(Yii::app()->params['timeLiveCache'], new STagCacheDependency(get_class($this), 'cache'));
        parent::beforeFind();
    }

    /*** обновление кеша ***/
    protected function afterSave(){
        Yii::app()->cache->set(get_class($this), microtime(true), 0);
        return parent::afterSave();
    }
    protected function afterDelete(){
        Yii::app()->cache->set(get_class($this), microtime(true), 0);
        return parent::afterDelete();
    }




    public function tableName()
    {
        return 'config';
    }

    public function rules()
    {
        return array(
            array('value', 'safe'),
            array('id, param, value, label, type, default', 'safe', 'on'=>'search'),
        );
    }
}