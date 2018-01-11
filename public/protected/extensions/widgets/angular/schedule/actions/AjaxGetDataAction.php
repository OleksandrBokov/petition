<?php

Yii::import('application.extensions.widgets.angular.schedule.models.ScheduleActiveRecords');

class AjaxGetDataAction extends CAction
{
    public function run($entity_id)
    {
         $model = EntitySchedule::model()->findByAttributes(['entity_id'=>$entity_id]);
         $data = ScheduleActiveRecords::model()->getScheduleData($model);
         echo json_encode($data);
         Yii::app()->end();
    }
}