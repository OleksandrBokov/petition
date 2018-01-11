<?php

/**
 * Class DefaultController
 */
class DefaultController extends AdminController
{

    public function actionIndex()
    {
        $this->pageTitle = Yii::t('main', 'Петиция');
        $model = new Petition();
        $this->render('index', ['model'=>$model]);
    }


    public function actionView($id)
    {
        if(isset($id) && !empty($id)){
            $sectionName = EntityInfo::model()->findByAttributes(['entity_id'=>$id])->name;
        }
        else{
            $this->redirect('/owner/'.TypeEntity::TYPE_SECTION.'/default');
        }
        $this->pageTitle = Yii::t('main', 'n==1#секция |n<=4#секции |n>=10#секций', 1);
        $criteria = new CDbCriteria();
        $criteria->condition = 'entity_id=:entity_id AND user_id != :user_id';
        $criteria->params = [':entity_id'=>$id, ':user_id'=>Yii::app()->user->id ];
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
        unset($arr);
        $tmp_arr = array_values($cart);
        unset($cart);

        $customOrderSchedule = [];
        $iterator = 0;
        foreach ($tmp_arr as $arr){
            //$price = $this->getAllPrice($arr);
            $first_el = array_shift($arr);
           // $last_elem = array_pop($arr);
            $customOrderSchedule[] = [
                'id'=>++$iterator,
                //'name' => $first_el->entity->info->name,
                'start_time'=>DateHelper::convertTimeStamp($first_el['timestamp'], 'H:i d-m-Y', true),
                //'end_time'=>($last_elem['timestamp'] ? DateHelper::convertTimeStamp($last_elem['timestamp'], 'H:i d-m-Y', true) : ''),
               // 'price' => ($price ? $price.' грн' : '-'),
                'user' => $first_el->user
            ];
            unset($price);
            unset($first_el);
            unset($last_elem);

        }

        $dataProvider = new CArrayDataProvider(array_reverse($customOrderSchedule),
            [
                'sort'=>[
                    'attributes'=>[
                        'id'
                    ]
                ],
                'pagination'=> array(
                    'pageSize'  =>  10,
                ),
            ]
        );

        $this->render('view',['model'=>$dataProvider, 'section_name'=>$sectionName]);

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
    
}