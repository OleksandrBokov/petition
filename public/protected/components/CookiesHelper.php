<?php

class CookiesHelper extends CApplicationComponent {

    public function putCMsg($name, $value) {

        if (is_array($value)) {
            $cookie = new CHttpCookie($name, json_encode($value));
            $cookie->expire = time()+60*60*24*180;
        } else {
            $cookie = new CHttpCookie($name, $value);
            $cookie->expire = time()+60*60*24*180;
        }

        Yii::app()->request->cookies[$name] = $cookie;

        return true;
    }

    public function getCMsg($name) {
        if (!empty(Yii::app()->request->cookies[$name])) {
            $return = json_decode(Yii::app()->request->cookies[$name]);
            if (json_last_error() == JSON_ERROR_NONE && !is_string($return))
                return $return;
            else
                return Yii::app()->request->cookies[$name]->value;
        }else
            return false;
    }

    public function updateCMsg($name, $value) {
        if (!empty(Yii::app()->request->cookies[$name])) {
            $return = json_decode(Yii::app()->request->cookies[$name]);
            if (json_last_error() == JSON_ERROR_NONE && !is_string($return)) {
                array_push($return, $value);
                $this->putCMsg($name, $return);
               // Yii::app()->request->cookies[$name] = new CHttpCookie($name, json_encode($return));
                return true;
            } else {
                $this->putCMsg($name, $value);
               // Yii::app()->request->cookies[$name] = new CHttpCookie($name, $value);
                return true;
            }
        }else
            return 'Cookie not found';
    }

    public function delCMsg($name = NULL) {
        unset(Yii::app()->request->cookies[$name]);
        return true;
    }

}

?>