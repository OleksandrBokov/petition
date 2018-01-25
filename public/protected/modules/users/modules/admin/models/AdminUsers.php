<?php


class AdminUsers extends CActiveRecord
{

    public $new_password;

    public function init()
    {
        $this->role = User::ROLE_MANAGER;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return array(
            array('password, email', 'required'),
            array('email','email'),
            array('status', 'numerical', 'integerOnly'=>true),

            array('new_password', 'length', 'max'=>100),
            array('firstName, lastName', 'safe'),
            array('email', 'unique','message'=>Yii::t('app','A user with this email already exists.')),

            array('id, email, password, new_password, firstName, lastName, token, role, status', 'safe', 'on'=>'search'),
        );
    }



    protected function beforeSave()
    {
        if($this->isNewRecord){

            $m = new Mail();
            $message = $m->createMessage($this, 'account_create');
            Mailer::_createMailToHtml($message);
            $this->password = User::model()->createPasswordHash($this->password);
        }

        return parent::beforeSave();
    }



    public function updateUser($old_email, $old_status, $model)
    {
        if(!empty($model->new_password))
        {
            $m = new Mail();
            $message = $m->createMessage($model, 'reset_password');
            Mailer::_createMailToHtml($message);
            $model->password =  User::model()->createPasswordHash($model->new_password);
        }

        if($model->save())
            return true;
        else
            throw new CHttpException(404, $model->getErrors());
    }

    public function deleteUser($model)
    {
        if($model->delete()){
            return true;
        }
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}