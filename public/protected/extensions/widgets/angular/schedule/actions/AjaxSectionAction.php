<?php

Yii::import('application.extensions.widgets.angular.schedule.actions.GenerateWeek');
class AjaxSectionAction  extends CAction
{
    public function run($id)
    {

        header('Content-type: application/json', true, 200);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)){
            $_POST = json_decode(file_get_contents('php://input'), true);
        }

        $data = [];
        if(!empty($_POST['data']['date'])){
            $week = new GenerateWeek();
            $week = $week->run($_POST['data']['date'], $_POST['data']['step']);
        }else{
            $week = new GenerateWeek();
            $week = $week->run();
        }

        $data = $week;
        $model = EntitySchedule::model()->findAllByAttributes(['entity_id'=>$id]);

        foreach ($model as $item){
            foreach ($data['week'] as $k=>$v){

                if($item->day_id == $v['day_number']){
                    $timestamp = DateHelper::convertDateToTimeStamp($v['day'].'.'.$v['month_number'].'.'.$v['year'].' '.$item->time_start);
                    $data['week'][$k]['items'][] = CMap::mergeArray($item->attributes, ['timestamp'=>$timestamp]);

                }
            }
        }

        echo json_encode($data);
        Yii::app()->end();
    }
}