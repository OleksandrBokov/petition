<?php

Yii::import('application.extensions.widgets.angular.schedule.models.ScheduleActiveRecords');
Yii::import('application.extensions.widgets.angular.schedule.actions.GenerateWeek');
class AjaxScheduleAction extends CAction
{
    public function run($id){

        header('Content-type: application/json', true, 200);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)){
            $_POST = json_decode(file_get_contents('php://input'), true);
        }

        if(!empty($_POST['data']['date'])){
            $week = new GenerateWeek();
            $week = $week->run($_POST['data']['date'], $_POST['data']['step']);
        }else{
            $week = new GenerateWeek();
            $week = $week->run();
        }


        $model = EntitySchedule::model()->findByAttributes(['entity_id'=>$id]);
        $data = ScheduleActiveRecords::model()->getScheduleByPlayground($model, $week);
        $data['margin_of_time'] = $model->margin_of_time; // маржа по времени
        $data['time_interval'] = $model->time_interval; // шаг по времени 1 час или 30 мин (1 , 0.5)

         echo json_encode($data);
         Yii::app()->end();
    }




}