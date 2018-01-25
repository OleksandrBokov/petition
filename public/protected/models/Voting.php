<?php

/**
 * This is the model class for table "voting".
 *
 * The followings are the available columns in table 'voting':
 * @property string $id
 * @property string $user_id
 * @property string $petition_id
 * @property integer $date_registration
 *
 * The followings are the available model relations:
 * @property Petition $petition
 * @property User $user
 */
class Voting extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'voting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, petition_id', 'required'),
			array('date_registration', 'numerical', 'integerOnly'=>true),
			array('user_id, petition_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, petition_id, date_registration', 'safe', 'on'=>'search'),
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
			'petition' => array(self::BELONGS_TO, 'Petition', 'petition_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'petition_id' => 'Petition',
			'date_registration' => 'Date Registration',
		);
	}

	protected function beforeSave()
	{
		$this->date_registration = DateHelper::setCurrentDateTimeToTimestamp();
		return parent::beforeSave();
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('petition_id',$this->petition_id,true);
		$criteria->compare('date_registration',$this->date_registration);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> 1000,
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Voting the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
