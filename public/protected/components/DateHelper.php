<?php

class DateHelper
{

    public static function convertTimeStamp($timestamp, $format = 'Y-m-d H:i:s', $rus = false)
    {
        $varDate = 0;

        if(is_numeric($timestamp)){
            $date = new DateTime();
            $date->setTimestamp($timestamp);
            $varDate = $date->format($format);

        }else{
            $varDate = self::convertDate($timestamp, true, 'd-m-Y');
        }

        if($rus){
            $varDate = self::translate($format, $timestamp);
        }

        return $varDate;
    }

    public static function setCurrentDateTimeToTimestamp()
    {
        //date_default_timezone_set('Europe/Kiev'); // Устанавливаем часовой пояс по Гринвичу
        $date = time();
        return $date;
    }

    public static function getCurrentDateTimeToTimestamp()
    {
        date_default_timezone_set('Europe/Kiev'); // Устанавливаем часовой пояс по Гринвичу
        $date = time();
        return $date;
    }


    public static function convertDateToTimeStamp($date)
    {
        return strtotime($date);
    }



    public static function convertDate($date, $convert = true, $format = 'Y-m-d'){

        if($convert){
            $date = new DateTime($date);
            return $date->format($format);
        }else{
            $date = new DateTime($date);
            return $date->format('Y-m-d H:i:s');
        }
    }


    protected static function translate($m)
    {
        $translate = array(
            "am" => "дп",
            "pm" => "пп",
            "AM" => "ДП",
            "PM" => "ПП",
            "Monday" => "Понедельник",
            "Mon" => "Пн",
            "Tuesday" => "Вторник",
            "Tue" => "Вт",
            "Wednesday" => "Среда",
            "Wed" => "Ср",
            "Thursday" => "Четверг",
            "Thu" => "Чт",
            "Friday" => "Пятница",
            "Fri" => "Пт",
            "Saturday" => "Суббота",
            "Sat" => "Сб",
            "Sunday" => "Воскресенье",
            "Sun" => "Вс",
            "January" => "Января",
            "Jan" => "Янв",
            "February" => "Февраля",
            "Feb" => "Фев",
            "March" => "Марта",
            "Mar" => "Мар",
            "April" => "Апреля",
            "Apr" => "Апр",
            "May" => "Мая",
            "June" => "Июня",
            "Jun" => "Июн",
            "July" => "Июля",
            "Jul" => "Июл",
            "August" => "Августа",
            "Aug" => "Авг",
            "September" => "Сентября",
            "Sep" => "Сен",
            "October" => "Октября",
            "Oct" => "Окт",
            "November" => "Ноября",
            "Nov" => "Ноя",
            "December" => "Декабря",
            "Dec" => "Дек",
            "st" => "ое",
            "nd" => "ое",
            "rd" => "е",
            "th" => "ое"
        );

        if (func_num_args() > 1) {
            $timestamp = func_get_arg(1);
            return strtr(date(func_get_arg(0), $timestamp), $translate);
        } else {
            return strtr(date(func_get_arg(0)), $translate);
        }
    }


    public static function checkingRelevance($timestamp)
    {
        $currentDate = self::getCurrentDateTimeToTimestamp();
        if($currentDate < $timestamp){
            return 1;
        }else{
            return 0;
        }
    }

}