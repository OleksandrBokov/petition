<?php

class WeekWidget extends CWidget
{
    var $local_time;
    var $prev = false;
    var $next = false;

    var $date = false;

    public function init()
    {
        $this->date = '1510063130';
//        echo "<pre>";
//        print_r(date('d.m.Y',$this->date));
//        echo "</pre>";
        $this->next = true;

        if(!$this->date)
            $this->local_time = time();
        else
            $this->local_time = $this->date;//'1510060279';


        if($this->prev)
            $this->local_time = strtotime("-7 day", $this->local_time);

        if($this->next)
            $this->local_time = strtotime("+7 day", $this->local_time);

        //return $this->rangeWeek();
        echo "<pre>";
        print_r($this->rangeWeek());
        echo "</pre>";

    }

    protected function rangeWeek()
    {
        $res = array();

        $startWeek =  $this->local_time;
        $finishWeek = strtotime("+7 day", $this->local_time);

        $res['startWeek'] = $startWeek;
        $res['finishWeek'] = $finishWeek;

//        echo "local_time : <pre>";
//        print_r(date('d.m.Y', $this->local_time));
//        echo "</pre>";
//        echo "startWeek :<pre>";
//        print_r(date('d.m.Y',$startWeek));
//        echo "</pre>";
//        echo "finishWeek :<pre>";
//        print_r(date('d.m.Y',$finishWeek));
//        echo "</pre>";

         for($i = 0; $i <= 6; $i++)
         {
             $res[date('N',strtotime('+'.$i.' day', $this->local_time))] = array(
                 'day' => date('j', strtotime('+'.$i.' day', $this->local_time)),
                 'month' => $this->get_month_name(date('m', strtotime('+'.$i.' day', $this->local_time))),
                 'day_name' => $this->get_day_names(date('N',strtotime('+'.$i.' day', $this->local_time)))
             );
         }

         return $res;
    }


    public function get_month_name($month)
    {
        $month_names = array(
            '01' => Yii::t('main','января'),
            '02' => Yii::t('main','февраля'),
            '03' => Yii::t('main','марта'),
            '04' => Yii::t('main','апреля'),
            '05' => Yii::t('main','мая'),
            '06' => Yii::t('main','июня'),
            '07' => Yii::t('main','июля'),
            '08' => Yii::t('main','августа'),
            '09' => Yii::t('main','сентября'),
            '10' => Yii::t('main','октября'),
            '11' => Yii::t('main','ноября'),
            '12' => Yii::t('main','декабря'),
        );
        
        return $month_names[$month];
    }

    public function get_day_names($day)
    {
        $day_names = array(
            '1' => Yii::t('main','пн'),
            '2' => Yii::t('main','вт'),
            '3' => Yii::t('main','ср'),
            '4' => Yii::t('main','чт'),
            '5' => Yii::t('main','пт'),
            '6' => Yii::t('main','сб'),
            '7' => Yii::t('main','вс'),
        );
        return $day_names[$day];
    }

}


