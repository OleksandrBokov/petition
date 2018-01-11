<?php

class Mailer
{
    public static $default;

    public function __construct()
    {

        self::$default = array(
            'path'=>'application.mail.template',
            'filename' => '.php',
            'to_email'=>Yii::app()->config->get('adminEmail'),
            'name'=>Yii::app()->name,
            'subject' => 'Test to send mail',
            'title' =>'Test to send mail',
            'message'=>'Test to send mail'
        );
    }
    /**
     * @param array $mail
     */
    public static  function _sendMail($mail)
    {
        $mailer = Yii::app()->MultiMailer->to($mail['to'], $mail['name']);

        $mailer->subject($mail['subject']);
        $mailer->body($mail['message']);

        try{
            $mailer->send();
            return true;
        }catch (Exception $e){
            echo Yii::t('main', 'Error! Email confirm is not sent.')."<br>".$mailer->getMultiError();die;
        }
    }

    /**
     * @param $data
     * @param bool $testMessageSend
     * @return bool
     */
    public static function _createMailToHtml($data, $testMessageSend = YII_DEBUG) //_sendMailToHtml
    {

        if($testMessageSend){
            self::_testHTML($data);
        } else{
             return self::_sendHTML($data);
        }
    }


    public static function _sendHTML($data = '')
    {
        ob_start();
        include YiiBase::getPathOfAlias($data['path']) . $data['filename'];

        if(!isset($data['from']) OR empty($data['from'])){
            $data['from'] = Yii::app()->name.' '.Yii::app()->config->get('adminEmail');
        }

        $mail = array(
            'to' => $data['to_email'],
            'from'=>  $data['from'],
            'name' => $data['name'],
            'subject' => $data['subject'],
            'message' => ob_get_clean()
        );

        /*** save Email to DB***/
        Email::model()->saveEmail($mail);

        if(self::_sendMail($mail))
            return true;
        else
            return false;
    }


    public static function _testHTML($data = ''){

        $path = Yii::getPathOfAlias('application').'/mail';
        $file_name = 'test.html';

        if(!$data && !is_array($data)){
            $data =  self::$default;
        }

        ob_start();
        include YiiBase::getPathOfAlias($data['path']) . $data['filename'];

        $mail = array(
            'to' => $data['to_email'],
            'from'=> Yii::app()->name.' '.Yii::app()->config->get('adminEmail'),
            'name' => $data['name'],
            'subject' => $data['subject'],
            'message' => ob_get_clean()
        );

        /*** save Email to DB***/
        Email::model()->saveEmail($mail);

        file_put_contents($path.'/'.$file_name, $mail, FILE_APPEND);
    }

}