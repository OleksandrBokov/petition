<?php

/**
 * Change pass form
 */
class ChangePasswordForm extends CFormModel
{

	/**
	 * @var string
	 */
	public $current_password;

	/**
	 * @var string
	 */
	public $new_password;

	/**
	 * @var User
	 */
	public $user;

	/**
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('current_password, new_password', 'required'),
			array('new_password', 'length', 'min'=>3, 'max'=>100),
			array('current_password', 'validateCurrentPassword'),
		);
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'current_password' => Yii::t('main', 'Текущий пароль'),
			'new_password' => Yii::t('main', 'Новый пароль'),
		);
	}

	public function validateCurrentPassword()
	{
		if(User::model()->createPasswordHash($this->current_password) != $this->user->password)
			$this->addError('current_password', Yii::t('main', 'Не верный текущий пароль'));
	}

}
