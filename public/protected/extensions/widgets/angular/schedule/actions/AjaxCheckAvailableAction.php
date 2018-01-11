<?php

Yii::import('application.extensions.widgets.angular.schedule.models.ScheduleActiveRecords');

class AjaxCheckAvailableAction extends CAction
{
    public function run($id)
    {
        header('Content-type: application/json', true, 200);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)){
            $_POST = json_decode(file_get_contents('php://input'), true);
        }

        if(isset($_POST['data'])){
            $response = array( 'status'=>1 );
            if(!ScheduleActiveRecords::model()->checkAvailable($id, $_POST['data']['timestamp'])){
                $response = array(
                    'status'=>0,
                    'error'=>'3'
                );
            }

//            foreach ($data as $key=>$value){
//                $data[$key]['used'] = ;
//            }

           // $old_order = Yii::app()->session->get('playground',$id);
           // echo json_encode( $data);
            echo json_encode($response);
            Yii::app()->end();
        }

    }


}

