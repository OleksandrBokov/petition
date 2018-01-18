<?php

/**
 * Class DefaultController
 */
class DefaultController extends AdminController
{

    public function actionIndex()
    {
        $this->pageTitle = Yii::t('main', 'Конфігурація');
        $this->render('index', array('items'=>$this->getItems()));
    }

    public function actionUpdate()
    {
        $this->pageTitle = Yii::t('main', 'Конфігурація');
        $items = $this->getItems(true);

        if(isset($_POST['Config'])){

            foreach ($items as $i => $item){

                if(isset($_POST['Config'][$item->param])){
                    $item->attributes = $_POST['Config'][$item->param];

                    $item->save();

                }
            }
            $this->redirect('/admin/config');

        }
        $this->render('update',['model'=>$items]);
    }

    public function getItems($p = false)
    {
        $items = ['capchaKey', 'capchaSecretKey'];
        $res = [];
        foreach ($items as $item){
            if(!$p){
                $dp = new CActiveDataProvider('Config', [
                    'criteria'=>[
                        'condition'=>'param = :param',
                        'params'=>[':param' => $item]
                    ]

                ]);
                $res[]=$dp;
            }
            else{
                $res[]=Config::model()->find('param = :param', [':param' => $item]);
            }

        }

        return $res;
    }

}