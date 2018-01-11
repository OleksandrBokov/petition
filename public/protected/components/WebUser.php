<?php


class WebUser extends CWebUser {

    private $_model = null;
    private $_status = null;

    /**
     * @return (user, owner, administrator)|null
     */
    function getRole() {
        if ($user = $this->getModel('role')) {
            return $user->role;
        }else{
            return false;
        }
    }

    function getStatus() {
        if ($user = $this->_getStatus()) {
            return $user->status;
        }else{
            return false;
        }
    }

    /**
     * @param $query
     * @return null|static
     */
    private function getModel($query) {
        if (!$this->isGuest && $this->_model === null) {
            $this->_model = User::model()->findByPk($this->id, array('select'=>$query));
        }
        return $this->_model;
    }

    /**
     * @return null|static
     */
    private function _getStatus() {

        if (!$this->isGuest && $this->_status === null) {
            $this->_status = User::model()->findByPk($this->id, array('select'=>'status'));
        }
        return $this->_status;
    }



//    public function setReturnUrl($value)
//    {
//        return parent::setReturnUrl($value);
//    }

}