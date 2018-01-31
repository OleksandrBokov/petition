<?php

class SiteController extends Controller
{

//	public function actionIndexOld()
//	{
//		if(Yii::app()->request->isAjaxRequest){
//
//			if(isset($_POST['Petition']) && isset($_POST['Petition']['id']) && is_numeric($_POST['Petition']['id'])){
//
//				$userVote = Voting::model()->findByAttributes(['user_id'=>Yii::app()->user->id]);
//
//				if(null === $userVote){
//
//					$userVote = new Voting();
//					$userVote->user_id = Yii::app()->user->id;
//					$userVote->petition_id = $_POST['Petition']['id'];
//					if (!$userVote->save())
////					if (!$userVote->validate())
//						exit(json_encode(array('result' => 'error', 'msg' => '<div class="vote-mssg">'.CHtml::errorSummary($userVote).'</div>')));
//					else
//						exit(json_encode(array('result' => 'success', 'msg' => '<div class="vote-mssg">Ви підписали петіцію</div>')));
//				}
//				exit(json_encode(array('result' => 'success', 'msg' => '<div class="vote-mssg">Ви підписали петіцію</div>>')));
//			}
//			else {
//				exit(json_encode(array('result' => 'error', 'msg' => '<div class="vote-mssg">Вам потрібно перезавантажити сторінку.</div>')));
//			}
//		}
//
//		$petition = Petition::model()->findAll();
//		$userVote = null;
//		$vote = new Voting('search');
//		$dataProvider = $vote->search();
//		if(!Yii::app()->user->isGuest){
//			$userVote = Voting::model()->findByAttributes(['user_id'=>Yii::app()->user->id]);
//		}
//
//		$vote->unsetAttributes();  // clear any default values
//		if(isset($_GET['Voting']))
//			$vote->attributes=$_GET['Voting'];
//
//		$this->render('index', array(
//				'userVote'=>$userVote,
//				'petition' => count($petition)?$petition[0]:'',
//				'votes' => $vote,
//				'dataProvider'=>$dataProvider
//			)
//		);
//	}
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$petition = Petition::model()->findAll();
		$userVote = null;

		if(!Yii::app()->user->isGuest){
			$userVote = User::model()->findByPk(Yii::app()->user->id);
		}

		$user =  new CustomUser('search');

		$user->unsetAttributes();  // clear any default values
		if(isset($_GET['UserCustom']))
			$user->attributes=$_GET['UserCustom'];

		$dataProvider = $user->search();

//		echo "<pre>";
//		print_r($dataProvider->getData());
//		echo "</pre>";die;

        $this->render('index', array(
			'userVote'=>$userVote,
			'petition' => count($petition)?$petition[0]:'',
			'votes' => $user,
			'dataProvider'=>$dataProvider
			)
		);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function actionGenerate(){

		echo RandomStringHelper::generate(Yii::app()->config->get('password_length'), Yii::app()->config->get('numberAndSymbolString'));
		die;
	}

}