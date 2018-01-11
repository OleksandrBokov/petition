<?php

/**
 * This is the model class for table "mail".
 *
 * The followings are the available columns in table 'mail':
 * @property string $id
 * @property string $title
 * @property string $content
 * @property string $type
 * @property string $link
 *
 * The followings are the available model relations:
 * @property MailLang[] $mailLangs
 */
class Mail extends CActiveRecord
{
    public $baseUrl;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'mail';
    }

    public function init()
    {
        $this->baseUrl = Yii::app()->getBaseUrl(true);
    }
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('type', 'required'),
            array('title', 'length', 'max'=>255),
            array('type, link', 'length', 'max'=>45),
            array('content', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, content, type, link', 'safe', 'on'=>'search'),
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
            'mailLangs' => array(self::HAS_MANY, 'MailLang', 'owner_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'type' => 'Type',
            'link' => 'Link',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('t.id',$this->id,true);
        $criteria->compare('t.title',$this->title,true);
        $criteria->compare('t.content',$this->content,true);
        $criteria->compare('t.type',$this->type,true);
        $criteria->compare('t.link',$this->link,true);

        return new CActiveDataProvider($this, array(
            'criteria' => $this->ml->modifySearchCriteria($criteria),
        ));
    }


    public function behaviors()
    {
        return array(
            'ml' => array(
                'class' => 'application.components.MultilingualBehavior',
                'localizedAttributes' => array('title','content','link'),
                ///langClassName' => 'CityLang',
                //'localizedPrefix' => 'l_',
                'langTableName' => '{{mail_lang}}',
                'languages' => Yii::app()->params['translatedLanguages'],
                'defaultLanguage' => Yii::app()->params['defaultLanguage'],
                'langForeignKey' => 'owner_id',
                'dynamicLangClass' => true, //Set to true if you don't want to create a 'CityLang.php' in your models folder
                //'createScenario' => 'insert',
                //'localizedRelation' => 'i18nCity',
                //'multilangRelation' => 'multilangCity',
                //'forceOverwrite' => false,
                //'forceDelete' => true,
            ),
        );
    }

    public function defaultScope()
    {
        return $this->ml->localizedCriteria();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Mail the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


    public function createMessage($model = '', $type )
    {

        $mail = Mail::model()->find('type=:type ',[':type'=>$type]);

        switch($type){
            case 'registration':
                $mail->content = $this->getRegisterContent($model, $mail);
                break;
            case 'reset_password':
                $mail->content = $this->getResetPasswordContent($model, $mail);
                break;
            case 'account_create' :
                $mail->content = $this->getAccountCreateContent($model, $mail);
                break;
            case 'new_task' :
                $model->email = Yii::app()->config->get('adminEmail');
                $mail->content = $this->getNewTaskCreateContent($model, $mail);
                break;
        }

        return $this->setData($model, $mail);
    }


    protected function setData($model, $mail)
    {
        $data['path'] = 'application.mail.template';
        $data['filename'] = '.php';
        $data['to_email'] = $model->email;
        $data['name'] = $model->email;
        $data['subject'] = $mail->title;
        $data['title'] = $mail->title;
        $data['message'] = $mail->content;

        return $data;
    }


    protected function getRegisterContent($model, $mail)
    {
        $link = $this->baseUrl;

        $link .= Yii::app()->createUrl('/login/validation', ['ref'=>$model->token]);
        return str_replace('{link}', CHtml::link($mail->link, $link),$mail->content);
    }

    protected function getResetPasswordContent($model, $mail)
    {
        return str_replace('{password}',$model->new_password, $mail->content);
    }


    protected function getAccountCreateContent($model, $mail)
    {

        $mail->content = str_replace('{firstName}',$model->firstName, $mail->content);
        $mail->content = str_replace('{lastName}',$model->lastName, $mail->content);
        $mail->content = str_replace('{application_name}',Yii::app()->name, $mail->content);
        $mail->content = str_replace('{email}',$model->email, $mail->content);
        $mail->content = str_replace('{password}',$model->password, $mail->content);

        return $mail->content;
    }

    protected function getNewTaskCreateContent($model, $mail)
    {
        $link = $this->baseUrl;
        $link .= Yii::app()->createUrl('/admin/task/');
        return str_replace('{link}', CHtml::link($mail->link, $link), $mail->content);
    }


    public static function AssignTask($model)
    {
        $link = Yii::app()->getBaseUrl(true);
        $mail = Mail::model()->find('type=:type ',[':type'=>'assign_task']);

        $data = false;

        $executor = User::model()->findByPk($model->executor_id);

        $link .= Yii::app()->createUrl('/'.$executor->role.'/task/task/new/');

        $mail->content = str_replace('{link}', CHtml::link($mail->link, $link), $mail->content);
        $data['path'] = 'application.mail.template';
        $data['filename'] = '.php';
        $data['to_email'] = $executor->email;
        $data['name'] = $executor->firstName . ' ' . $executor->lastName;
        $data['subject'] = $mail->title; // Заголовок
        $data['title'] = $mail->title; // Непонятная фигня
        $data['message'] = $mail->content;

        Mailer::_createMailToHtml($data);
    }


   /* public static function newCommentToTask($model)
    {
        $link = Yii::app()->getBaseUrl(true);
        $mail = Mail::model()->find('type=:type ',[':type'=>'new_comment_to_task']);

        $user = $model->toUser;

        if($user->role == User::ROLE_ADMIN) {
            $link .= Yii::app()->createUrl('/admin/task/default/view', ['id' => $model->task_id]);
        }
        if($user->role == User::ROLE_MANAGER){
            $link .= Yii::app()->createUrl('/manager/task/task/view', ['id' => $model->task_id]);
        }

        $mail->content = str_replace('{link}', CHtml::link($mail->link, $link), $mail->content);
        $data['path'] = 'application.mail.template';
        $data['filename'] = '.php';
        $data['to_email'] = $user->email;
        $data['name'] = $user->firstName . ' ' . $user->lastName;
        $data['subject'] = $mail->title; // Заголовок
        $data['title'] = $mail->title; // Непонятная фигня
        $data['message'] = $mail->content;

        Mailer::_createMailToHtml($data);

    }*/



    public static function createMassageToOwnerPlayground($owner_id, $user, $cart, $interval)
    {

        if(!empty($owner_id))
        {

            $content = '';
            $content .= self::getUserData($user);
            $content .= self::getCartData($cart, $interval);


            $owner = User::model()->findByPk($owner_id);


            $data['path'] = 'application.mail.template';
            $data['filename'] = '.php';
            $data['to_email'] = $owner->email;
            $data['from'] = Yii::app()->config->get('adminEmail');
            $data['name'] = Yii::app()->name.', '.Yii::t('main','заявка|заявки|заявок', 1);
            $data['subject'] = Yii::app()->name.', '.Yii::t('main','заявка|заявки|заявок', 1);
            $data['title'] = Yii::app()->name.', '.Yii::t('main','заявка|заявки|заявок', 1);
            $data['message'] = $content;

            Mailer::_createMailToHtml($data);
        }
    }

    public static function createMassageToUserPlayground( $model, $user, $cart, $interval)
    {

        $content = '';
        $content .= self::getEntityData($model);
        $content .= self::getCartData($cart, $interval);

        $data['path'] = 'application.mail.template';
        $data['filename'] = '.php';
        $data['to_email'] = $user->email;
        $data['from'] = Yii::app()->config->get('adminEmail');
        $data['name'] = Yii::app()->name.', '.Yii::t('main','заявка|заявки|заявок', 1);
        $data['subject'] = Yii::app()->name.', '.Yii::t('main','заявка|заявки|заявок', 1);
        $data['title'] = Yii::app()->name.', '.Yii::t('main','заявка|заявки|заявок', 1);
        $data['message'] = $content;

        Mailer::_createMailToHtml($data);
    }
    
    public static function createMassageToOwnerSection($model, $order, $user)
    {
        $content = '';
        $content .= self::getUserData($user);
        $content .= self::getSectionData($order, $model);

        $data['path'] = 'application.mail.template';
        $data['filename'] = '.php';
        $data['to_email'] = $model->owner->email;
        $data['from'] = Yii::app()->config->get('adminEmail');
        $data['name'] = Yii::app()->name.', '.Yii::t('main','заявка|заявки|заявок', 1);
        $data['subject'] = Yii::app()->name.', '.Yii::t('main','заявка|заявки|заявок', 1);
        $data['title'] = Yii::app()->name.', '.Yii::t('main','заявка|заявки|заявок', 1);
        $data['message'] = $content;

        Mailer::_createMailToHtml($data);
    }
    
    public static function createMassageToUserSection($model, $order, $user)
    {
        $content = '';
        $content .= self::getSectionData($order, $model);

        $data['path'] = 'application.mail.template';
        $data['filename'] = '.php';
        $data['to_email'] = $user->email;
        $data['from'] = Yii::app()->config->get('adminEmail');
        $data['name'] = Yii::app()->name.', '.Yii::t('main','заявка|заявки|заявок', 1);
        $data['subject'] = Yii::app()->name.', '.Yii::t('main','заявка|заявки|заявок', 1);
        $data['title'] = Yii::app()->name.', '.Yii::t('main','заявка|заявки|заявок', 1);
        $data['message'] = $content;

        Mailer::_createMailToHtml($data);
    }

    protected static function getSectionData($order, $model)
    {
        $cnt = '';
        $cnt .= CHtml::openTag('table');
        $cnt .= CHtml::openTag('tbody');

        $cnt .= CHtml::openTag('tr');
        $cnt .= CHtml::openTag('td');
        $cnt .= Yii::t('main', 'n==1#секция |n<=4#секции |n>=10#секций', 1);
        $cnt .= CHtml::closeTag('td');
        $cnt .= CHtml::openTag('td');
        $cnt .= $model->info->name;
        $cnt .= CHtml::closeTag('td');
        $cnt .= CHtml::closeTag('tr');

        $cnt .= CHtml::openTag('tr');
        $cnt .= CHtml::openTag('td');
        $cnt .= Yii::t('main', 'адрес');
        $cnt .= CHtml::closeTag('td');
        $cnt .= CHtml::openTag('td');
        $cnt .= $model->info->address;
        $cnt .= CHtml::closeTag('td');
        $cnt .= CHtml::closeTag('tr');

        $cnt .= CHtml::openTag('tr');
        $cnt .= CHtml::openTag('td');
        $cnt .= Yii::t('main', 'Занятие');
        $cnt .= CHtml::closeTag('td');
        $cnt .= CHtml::openTag('td');
        $cnt .= DateHelper::convertTimeStamp($order->timestamp, 'd F', true).' '.Yii::t('main','в').' '.DateHelper::convertTimeStamp($order->timestamp, 'H:i', true);
        $cnt .= CHtml::closeTag('td');
        $cnt .= CHtml::closeTag('tr');

        $cnt .= CHtml::closeTag('tbody');
        $cnt .= CHtml::closeTag('table');

        return $cnt;
    }
    

    protected static function getEntityData($model)
    {
        $cnt = '';
        $cnt .= CHtml::openTag('table');
        $cnt .= CHtml::openTag('tbody');

        $cnt .= CHtml::openTag('tr');
        $cnt .= CHtml::openTag('td');
        $cnt .= Yii::t('main','заявка|заявки|заявок', 1).' '.Yii::t('main','от');
        $cnt .= CHtml::closeTag('td');
        $cnt .= CHtml::openTag('td');
        $cnt .= DateHelper::convertTimeStamp(time(), 'd.m.Y');
        $cnt .= CHtml::closeTag('td');
        $cnt .= CHtml::closeTag('tr');
        
        $cnt .= CHtml::openTag('tr');
        $cnt .= CHtml::openTag('td');
        $cnt .= Yii::t('main','n==1#площадка |n<=4#площадки |n>=10#площадок', 1);
        $cnt .= CHtml::closeTag('td');
        $cnt .= CHtml::openTag('td');
        $cnt .= $model->info->name;
        $cnt .= CHtml::closeTag('td');
        $cnt .= CHtml::closeTag('tr');

        $cnt .= CHtml::openTag('tr');
        $cnt .= CHtml::openTag('td');
        $cnt .= Yii::t('main','адрес');
        $cnt .= CHtml::closeTag('td');
        $cnt .= CHtml::openTag('td');
        $cnt .= $model->info->address;
        $cnt .= CHtml::closeTag('td');
        $cnt .= CHtml::closeTag('tr');


        $cnt .= CHtml::closeTag('tbody');
        $cnt .= CHtml::closeTag('table');

        return $cnt;
    }
    
    
    protected static function getUserData($user)
    {
        $cnt = '';
        $cnt .= CHtml::openTag('table');
        $cnt .= CHtml::openTag('tbody');

        $cnt .= CHtml::openTag('tr');
        $cnt .= CHtml::openTag('td');
        $cnt .= Yii::t('main','заявка|заявки|заявок', 1).' '.Yii::t('main','от');
        $cnt .= CHtml::closeTag('td');
        $cnt .= CHtml::openTag('td');
        $cnt .= DateHelper::convertTimeStamp(time(), 'd.m.Y');
        $cnt .= CHtml::closeTag('td');
        $cnt .= CHtml::closeTag('tr');

        $cnt .= CHtml::openTag('tr');
        $cnt .= CHtml::openTag('td');
        $cnt .= Yii::t('main','ФИО');
        $cnt .= CHtml::closeTag('td');
        $cnt .= CHtml::openTag('td');
        $cnt .=  $user->firstName.' '.$user->lastName;
        $cnt .= CHtml::closeTag('td');
        $cnt .= CHtml::closeTag('tr');

        $cnt .= CHtml::openTag('tr');
        $cnt .= CHtml::openTag('td');
        $cnt .= Yii::t('main','Email');
        $cnt .= CHtml::closeTag('td');
        $cnt .= CHtml::openTag('td');
        $cnt .=  $user->email;
        $cnt .= CHtml::closeTag('td');
        $cnt .= CHtml::closeTag('tr');

        $cnt .= CHtml::openTag('tr');
        $cnt .= CHtml::openTag('td');
        $cnt .= Yii::t('main','Телефон');
        $cnt .= CHtml::closeTag('td');
        $cnt .= CHtml::openTag('td');
        $cnt .=  $user->phone;
        $cnt .= CHtml::closeTag('td');
        $cnt .= CHtml::closeTag('tr');

        $cnt .= CHtml::closeTag('tbody');
        $cnt .= CHtml::closeTag('table');

        return $cnt;

    }


    protected static function getCartData($cart, $interval)
    {
        $summaryPrice = 0;

        $cnt = '';
        $cnt .= CHtml::openTag('table');
        $cnt .= CHtml::openTag('tbody');
        foreach ($cart as $k=>$value)
        {
            $cnt .= CHtml::openTag('tr');

            $cnt .= CHtml::openTag('td');
            $cnt .= $cart[$k][0]['day'].' '.$cart[$k][0]['month'].', '.$cart[$k][0]['day_name'];
            $cnt .= CHtml::closeTag('td');

            $cnt .= CHtml::openTag('td');
            $c = count($cart[$k]) - 1;
            $finish =$cart[$k][$c]['timestamp'] + 60 * $interval * 60;
            $cnt .= DateHelper::convertTimeStamp($cart[$k][0]['timestamp'], 'H:i').' - '.DateHelper::convertTimeStamp($finish, 'H:i');
            $cnt .= CHtml::closeTag('td');


            $cnt .= CHtml::openTag('td');
            $price = 0;
            foreach ($cart[$k] as $item){
                $price += $item['price'];
            }
            $summaryPrice += $price;
            $cnt .= $price.' грн.';
            $cnt .= CHtml::closeTag('td');


            $cnt .= CHtml::closeTag('tr');
        }
        $cnt .= CHtml::closeTag('tbody');

        
        $cnt .= CHtml::openTag('tfoot');
        $cnt .= CHtml::openTag('tr');

        $cnt .= CHtml::openTag('td');
        $cnt .= Yii::t('main','Всего').': ';
        $cnt .= CHtml::closeTag('td');

        $cnt .= CHtml::openTag('td');
        $cnt .= $summaryPrice.' грн.';
        $cnt .= CHtml::closeTag('td');

        $cnt .= CHtml::closeTag('tr');
        $cnt .= CHtml::closeTag('tfoot');

        
        $cnt .= CHtml::closeTag('table');

        return $cnt;
    }

}
