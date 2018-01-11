<?php

class SiteController extends Controller
{

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{

        //$categories['playground'] = CategorySearch::model()->getNodes(TypeEntity::getIdByUrl(TypeEntity::TYPE_PLAYGROUND));
        //$categories['section'] = CategorySearch::model()->getNodes(TypeEntity::getIdByUrl(TypeEntity::TYPE_SECTION));
        //$categories['place'] = CategorySearch::model()->getNodes(TypeEntity::getIdByUrl(TypeEntity::TYPE_PLACE));

        //$new_offer = Entity::model()->getNewOffer();

//        $this->render('index',['categories'=>$categories,'new_offer'=>$new_offer]);
        $this->render('index');
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


}