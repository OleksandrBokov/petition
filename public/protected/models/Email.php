<?php

/**
 * This is the model class for table "email".
 *
 * The followings are the available columns in table 'email':
 * @property string $id
 * @property string $email
 * @property string $name
 * @property string $subject
 * @property string $message
 * @property string $alt
 * @property string $from
 * @property integer $create_at
 */
class Email extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'email';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email', 'required'),
			array('create_at, status', 'numerical', 'integerOnly'=>true),
			array('email, name, subject, alt, from', 'length', 'max'=>255),
			array('message', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, name, subject, message, alt, from, create_at', 'safe', 'on'=>'search'),
		);
	}

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class'=>'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate'=>false,
                'createAttribute'=>'create_at',
            ),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'name' => 'Name',
			'subject' => 'Subject',
			'message' => 'Message',
			'alt' => 'Alt',
			'from' => 'From',
			'create_at' => 'Create At',
            'status' => 'Status',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('alt',$this->alt,true);
		$criteria->compare('from',$this->from,true);
		$criteria->compare('create_at',$this->create_at);
        $criteria->compare('status',$this->status);


        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Email the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function saveEmail($mail)
    {
        $email = new Email();
        $email->email = $mail['to'];
        $email->name = $mail['name'];
        $email->from = $mail['from'];
        $email->subject = $mail['subject'];
        $email->message = $mail['message'];
        if(!$email->save()){
            echo "<pre>";
            print_r($email->getErrors());
            echo "</pre>";die;
        }

    }
}
