<?php

class ScheduleActiveRecords extends CActiveRecord
{

    public $time_day_id;

    public function tableName()
    {
        return 'playground_schedule_template';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('entity_id, day_id, time_day_id, time', 'required'),
            array('time_day_id', 'numerical', 'integerOnly'=>true),
            array('entity_id, day_id, time', 'length', 'max'=>10),
            array('price', 'length', 'max'=>45),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, entity_id, day_id, time_day_id, time, price', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'entity' => array(self::BELONGS_TO, 'Entity', 'entity_id'),
            'day' => array(self::BELONGS_TO, 'DayWeek', 'day_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'entity_id' => 'Entity',
            'day_id' => 'Day',
            'time_day_id' => 'Time Day',
            'time' => 'Time',
            'price' => 'Price',
        );
    }


    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getScheduleData($schedule)
    {
        if(!$schedule)
            throw new CException(Yii::t('yiiext','The schedule can not be empty.'));


        $data = array();
        $items = array();

        $data['days'] = $this->getDays($schedule);
        $data['times'] = $this->getTimes($schedule);



        $model = $this->findAllByAttributes(['entity_id'=>$schedule->entity_id]);

        foreach ($model as $item){
            $items[$item->time_day_id] = $item->attributes;
        }

        $result = $this->setItems( $data, $items );

        return $result;
    }


    function setItems($data, $items)
    {
        $data['items'] = array();
        foreach ($data['days'] as $key=>$value)
        {
            foreach ($data['times'] as $k=>$v)
            {

                if(isset($items[$k.$key]))
                {
                    $data['items'][$k.$key] = array(
                        'day_id'=>$items[$k.$key]['day_id'],
                        'time_id'=>$k,
                        'time'=>$items[$k.$key]['time'],
                        'time_day_id'=>$items[$k.$key]['time_day_id'],
                        'id'=>$items[$k.$key]['id'],
                        'price'=>$items[$k.$key]['price'],
                        'selected'=>0,
                        'used'=>1
                    );
                }else{
                    $data['items'][$k.$key] = array(
                        'day_id'=>$key,
                        'time_id'=>$k,
                        'time'=>$v['time'],
                        'time_day_id'=>$k.$key,
                        'id'=>0,
                        'price'=>'0',
                        'selected'=>0,
                        'used'=>0
                    );
                }
            }
        }
        return $data;
    }


    function getDays($schedule)
    {
        $arr = array();
        $days = DayWeek::model()->findAll();

        foreach ($days as $day){
            if( ($day->sort >= $schedule->day_with_id) && ($day->sort <= $schedule->day_by_id))
            {
                $arr[$day->sort] = array(
                    'name'=>$day->short_name,
                   // 'selected'=>0
                );
            }
        }
        return $arr;
    }

    function getTimes($schedule)
    {

        $time_start = (int)$schedule->time_start;
        $time_finish = (int)$schedule->time_finish;
        $arr = array();
        for ( $j = $time_start; $j < $time_finish; $j = $j + $schedule->time_interval){
            $arr[$j*2] = array(
                'time'=>$this->setTimeValue($j),
               // 'selected'=>0
            );
        }
        return $arr;
    }


    function setTimeValue($time){
        $tmp = intval($time/0.5);
        if($tmp % 2 == 1){
            if($time < 10)
                $res = '0'.intval($time).':30';
            else
                $res = intval($time).':30';
        }else{
            if($time < 10)
                $res = '0'.intval($time).':00';
            else
                $res = intval($time).':00';
        }
        return $res;
    }


    /**** создание шаблона расписания ***/
    public function setScheduleTemplateData( $data, $entity_id)
    {
        $status = true;

        foreach ($data as $key=>$value){

            if($value['id'] == 0)
            {
                $model = new $this;
                $model->entity_id = $entity_id;
                $model->day_id = $value['day_id'];
                $model->time_day_id = $value['time_day_id'];
                $model->time = $value['time'];
                $model->price = $value['price'];

                if($model->price != 0){
                    if(!$model->save())
                        $status = $status && false;
                }

            }else{
                $model = $this->findByPk($value['id']);
                $model->price = $value['price'];

                if($model->price != 0){
                    if(!$model->save())
                        $status = $status && false;
                }else{
                     $model->delete();
                }
            }
        }
        return $status;
    }



    /** расписание для площадок **/
    public function getScheduleByPlayground($model, $week)
    {
        $data = $week;
        $data['times'] = $this->getTimes($model);
        $data['cart'] = array();

        $model = $this->findAllByAttributes(['entity_id'=>$model->entity_id]);

        $schedule = array();

        foreach ($model as $k => $v){
            $schedule[$v->time_day_id]['time_day_id'] = $v->time_day_id;
            $schedule[$v->time_day_id] = $v->attributes;
        }

        $cart = OrderSchedule::getCartData($model[0]->entity_id);

        if(isset($cart))
            $data = CMap::mergeArray($data , OrderSchedule::getCartData($model[0]->entity_id));

        return self::renderItems($data, $schedule, $model[0]->entity_id);
    }


    /**
     * @param $data
     * @param $schedule
     * @param $entity_id
     * @return mixed
     */
    protected static function renderItems($data, $schedule, $entity_id)
    {
        foreach ($data['week'] as $key=>$value)
        {
            foreach ($data['times'] as $k=>$v)
            {
                if(isset($schedule[$k.$value['day_number']]))
                {
                    /** есть в шаблоне расписания **/
                    $timestamp = DateHelper::convertDateToTimeStamp($value['day'].'.'.$value['month_number'].'.'.$value['year'].' '.$schedule[$k.$value['day_number']]['time']);

                    $data['items']["'".$k.$value['day_number']."'"] = array(
                        'day_id'=>$schedule[$k.$value['day_number']]['day_id'],
                        'timestamp'=>$timestamp,
                        'day'=>$value['day'],
                        'day_name'=>$value['day_name'],
                        'month'=>$value['month'],
                        'month_number'=>$value['month_number'],
                        'year'=>$value['year'],
                        'time_id'=>$k,
                        'time'=>$schedule[$k.$value['day_number']]['time'],
                        'time_day_id'=>$schedule[$k.$value['day_number']]['time_day_id'],
                        'id'=>$schedule[$k.$value['day_number']]['id'],
                        'price'=>$schedule[$k.$value['day_number']]['price'],
                        'selected'=>self::checkSelected($entity_id, $timestamp),//(isset($itemSelected[$timestamp])) ? 1 : 0,
                        'used'=>self::checkAvailable($entity_id,$timestamp)
                    );
                }else{
                    /** нет в шаблоне расписания **/
                    $data['items']["'".$k.$value['day_number']."'"] = array(
                        'day_id'=>$value['day_number'],
                        'time_id'=>$k,
                        'time'=>$v['time'],
                        'time_day_id'=>$k.$value['day_number'],
                        'id'=>0,
                        'price'=>'',
                        'selected'=>0,
                        'used'=>0
                    );
                }
            }
        }

        return $data;
    }



    /** выбрано ли время **/
    protected static function checkSelected($id,$timestamp){
        $res = 0;
        $items = OrderSchedule::getCartData($id);//Yii::app()->session->get('playground',$id);

        foreach ($items['cart'] as $item){
            if($item['timestamp'] == $timestamp ){
                $res = 1;
            }
        }
        return $res;
    }


    /**** занято ли время ***/
    public static function checkAvailable($id, $timestamp)
    {
        $item = OrderSchedule::model()->findByAttributes(['entity_id'=>$id, 'timestamp'=> (int)$timestamp]);

        if(($item && OrderSchedule::checkValidDate($timestamp)) || (!$item  && !OrderSchedule::checkValidDate($timestamp))){
            return 0;
        }
        return 1;
    }

}