<?php

class DefaultController extends UserController
{

    /**
     * Index action
     */
    public function actionIndex()
    {
        $this->pageTitle = Yii::t('main','Личные данные');
        $model = UserCustom::model()->findByPk(Yii::app()->user->id);

        $this->render('index',['model'=>$model]);
    }

    /**
     * Update action
     */
    public function actionUpdate()
    {
        Yii::import('application.modules.profile.modules.user.forms.ChangePasswordForm');
        $request=Yii::app()->request;
        $model=UserCustom::model()->findByPk(Yii::app()->user->id);;

        $changePasswordForm=new ChangePasswordForm();
        $changePasswordForm->user=$model;
        $this->pageTitle = Yii::t('main','Редактировать');

        if(Yii::app()->request->isPostRequest)
        {
            if(isset($_POST['UserCustom']))
            {
                $model->attributes=$_POST['UserCustom'];
                if($model->save()){
                    $this->redirect('index');
                }
            }

            if($request->getPost('ChangePasswordForm'))
            {
                $changePasswordForm->attributes=$request->getPost('ChangePasswordForm');
                if($changePasswordForm->validate())
                {
                    $model->password=User::model()->createPasswordHash($changePasswordForm->new_password);
                    $model->save(false);
                    $this->refresh();
                }
            }
        }
        

        $this->render('update',['model'=>$model, 'changePasswordForm'=>$changePasswordForm]);
    }
}
