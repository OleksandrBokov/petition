<?php


class DefaultController extends AdminController
{

    public function actionIndex()
    {
        $this->pageTitle = Yii::t('app', 'n==1#user|n==2#user|n>=3#users',3);
        $this->_load();
    }

    public function actionCreate()
    {
        $model = new AdminUsers();
        $this->pageTitle = Yii::t('app', 'added|add',2).' '.Yii::t('app', 'n==1#user|n==2#user|n>=3#users',2);
        if(isset($_POST['AdminUsers'])){

            $model->attributes =$_POST['AdminUsers'];

            $model->status = User::STATUS_AUTHORIZED;

            if($model->save()){
                $this->redirect('/admin/users');
            }
        }

        $this->_load($model);
    }

    /**
     * @param $id
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $old_status = $model->status;
        $old_email = $model->email;

        $this->pageTitle = Yii::t('app','edit').' '.Yii::t('app', 'n==1#user|n==2#user|n>=3#users',2);
        if(isset($_POST['AdminUsers'])){
            $model->attributes =$_POST['AdminUsers'];
            if($model->validate())
            {
                if(AdminUsers::model()->updateUser($old_email, $old_status, $model)){
                    $this->redirect('/admin/users');
                }
            }
        }
        $this->_load($model);
    }

    /**
     * @param $id
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);

        if(AdminUsers::model()->deleteUser($model)){
            echo true;
        }
    }

    /**
     * @param array $data
     */
    protected function _load($data = array())
    {
        $model = new User('search');
        $model = $this->search($model);


        if (isset($_GET['userToPage'])){
            Yii::app()->user->setState('userToPage',(int)$_GET['userToPage']);
            unset($_GET['userToPage']);
        }

        $this->render('index',[
            'model'=>$model,
            'data'=>$data,

        ]);
    }

    /**
     * @param $model
     * @return mixed
     */
    protected function search($model)
    {
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['User']))
            $model->attributes=$_GET['User'];

        $model->role = User::ROLE_MANAGER;

        return $model;
    }

    /**
     * @param $id
     * @return mixed
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = AdminUsers::model()->findByPk((int) $id);

        if ($model === null)
            throw new CHttpException(404, 'The requested post does not exist.');
        return $model;
    }


}