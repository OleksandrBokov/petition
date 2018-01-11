<?php

/**
 * Class DefaultController
 */
class DefaultController extends UserController
{
    /**
     * empty action
     */
	public function actionIndex()
	{
        $this->pageTitle = Yii::t('main','Мои бронирования');
        $criteria = new CDbCriteria();
        $criteria->condition = 'user_id=:user_id';
        $criteria->params = [':user_id'=>Yii::app()->user->id ];
        $criteria->order = 'timestamp';

        $arr = OrderSchedule::model()->findAll($criteria);

        $count = count($arr);
        $cart = [];
        for ($i = 0; $i < $count; $i++) {

            if (!isset($arr[$i])) {
                continue;
            }
            else{
                $interval = $arr[$i]->entity->entitySchedules[0]->time_interval;
            }
            $cart[$i] = [];
            array_push($cart[$i], $arr[$i]);

            $step = $arr[$i]['timestamp'] + 60 * $interval * 60;

            for ($j = 0; $j < $count; $j++) {

                if (isset($arr[$j])) {
                    if ($step == $arr[$j]['timestamp']) {
                        array_push($cart[$i], $arr[$j]);
                        $step = $arr[$j]['timestamp'] + 60 * $interval * 60;
                        unset($arr[$i]);
                        unset($arr[$j]);
                    }

                }
            }
        }

        $tmp_arr = array_values($cart);
        unset($cart);

        $customOrderSchedule = [];
        $iterator = 0;
        foreach ($tmp_arr as $arr){
            $price = $this->getAllPrice($arr);
            $first_el = array_shift($arr);
            $last_elem = array_pop($arr);
            $customOrderSchedule[] = [
                'id'=>++$iterator,
                'name' => $first_el->entity->info->name,
                'start_time'=>DateHelper::convertTimeStamp($first_el['timestamp'], 'H:i d-m-Y', true),
                'end_time'=>($last_elem['timestamp'] ? DateHelper::convertTimeStamp($last_elem['timestamp'], 'H:i d-m-Y', true) : ''),
                'price' => ($price ? $price.' грн' : '-')
            ];

        }

        $dataProvider = new CArrayDataProvider(array_reverse($customOrderSchedule),
            [
                'sort'=>[
                    'attributes'=>[
                        'id'
                    ]
                ],
                'pagination'=> array(
                    'pageSize'  =>  15,
                ),
            ]
            );

        $this->render('index',['model'=>$dataProvider]);
	}

    /**
     * @param $orderSchedulesArr
     * @return int
     */
    public function getAllPrice($orderSchedulesArr){
        $price = 0;
        foreach ($orderSchedulesArr as $orderSchedule){
            $price += $orderSchedule->price;
        }

        return $price;
    }

    /**
     * Login action
     */
    public function actionLogin()
    {
        $this->layout = false;

        $model=new UserLoginForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        // collect user input data
        if(isset($_POST['UserLoginForm']))
        {
            $model->attributes=$_POST['UserLoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login()){
                Yii::app()->user->setReturnUrl('/user');
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        // display the login form
        $this->render('login',array('model'=>$model));

    }


}