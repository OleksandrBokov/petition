<?php

Yii::import('application.extensions.widgets.angular.schedule.models.ScheduleActiveRecords');
class AjaxSetDataAction extends CAction
{

    public function run($entity_id)
    {
        header('Content-type: application/json', true, 200);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)){
            $_POST = json_decode(file_get_contents('php://input'), true);
        }

        if(ScheduleActiveRecords::model()->setScheduleTemplateData($_POST['data'],$entity_id)){
            $response = array(
                'response'=>'success',
                'message'=>Yii::t('main','Сохранение прошло успешно')
            );
            echo json_encode($response);
            Yii::app()->end();
        }
    }

}