<?php

/**
 * Class DefaultController
 */
class AnswerController extends ModeratorController
{
    public function actionIndex()
    {
        $this->pageTitle = Yii::t('main', 'Ответ на петицию');
        $model = new PetitionAnswer();
        $this->render('index', ['model'=>$model]);
    }

    public function actionCreate()
    {
        $this->pageTitle = Yii::t('main', 'Создать').' '. Yii::t('main', 'Ответ');
        $model = new PetitionAnswer();

        if (isset($_POST['PetitionAnswer'])) {
//            echo "<pre>";
//            print_r($_POST['PetitionAnswer']);
//            echo "</pre>";die;
            $model->attributes = $_POST['PetitionAnswer'];
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl('moderator/petition/answer'));
            }
            else{
                echo "<pre>";
                print_r($model->getErrors());
                echo "</pre>";
            }
        }

        $this->render('create', ['model'=>$model]);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser

        $this->redirect('/moderator/petition/answer');
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Petition the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=PetitionAnswer::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}