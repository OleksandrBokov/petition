<?php


class AjaxCartAction extends CAction
{
    public function run($id)
    {
        header('Content-type: application/json', true, 200);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)){
            $_POST = json_decode(file_get_contents('php://input'), true);
        }

        if(isset($_POST['data']) ){

            Yii::app()->session->add('playground', [] );

            $arr = array( $id =>$_POST['data'] );
            Yii::app()->session->add('playground', $arr );
            echo json_encode(Yii::app()->session->get('playground'));
            Yii::app()->end();
        }
    }
}