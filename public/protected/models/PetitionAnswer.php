<?php

/**
 * This is the model class for table "petition_answer".
 *
 * The followings are the available columns in table 'petition_answer':
 * @property string $id
 * @property string $petition_id
 * @property string $answer
 * @property integer $date_create
 *
 * The followings are the available model relations:
 * @property Petition $petition
 */
class PetitionAnswer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'petition_answer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(//petition_id
			['petition_id','required'],
			array('date_create', 'numerical', 'integerOnly'=>true),
			array('petition_id', 'length', 'max'=>10),
			array('answer', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, petition_id, answer, date_create', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'petition_id' => 'Назва петиції',
			'answer' => 'Answer',
			'date_create' => 'Date Create',
		);
	}

	protected function beforeSave()
	{
		if($this->isNewRecord)
		{
			$this->date_create = DateHelper::setCurrentDateTimeToTimestamp();
		}

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
		$criteria->compare('petition_id',$this->petition_id,true);
		$criteria->compare('answer',$this->answer,true);
		$criteria->compare('date_create',$this->date_create);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PetitionAnswer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
