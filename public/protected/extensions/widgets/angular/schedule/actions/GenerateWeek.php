<?php

class GenerateWeek
{
    protected $_local_time;

    public function run($date = false, $step = false)
    {
        $this->_local_time = time();

        if($date){
            $this->step = $date;

            if($step){
                $this->_local_time = strtotime("-7 day", $date);
            }else{
                $this->_local_time = $date;
            }
        }

        return $this->rangeWeek();
    }

    protected function rangeWeek()
    {
        $res = array();

        $res['startWeek'] = $this->_local_time;
        $res['finishWeek'] = strtotime("+7 day", $this->_local_time);

        for($i = 0; $i <= 6; $i++)
         {
             $day_number = date('N',strtotime('+'.$i.' day', $this->_local_time));
             $weekend = ( $day_number == 6 || $day_number == 7) ? 1 : 0;

             $res['week'][$i] = array(
                 'day_number'=> $day_number,
                 'day' => date('j', strtotime('+'.$i.' day', $this->_local_time)),
                 'month' => $this->get_month_name(date('m', strtotime('+'.$i.' day', $this->_local_time))),
                 'month_number'=> date('m', strtotime('+'.$i.' day', $this->_local_time)),
                 'year' => date('Y', strtotime('+'.$i.' day', $this->_local_time)),
                 'day_name' => $this->get_day_names($day_number),
                 'weekend'=>$weekend
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


