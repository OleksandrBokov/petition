<?php

/**
 * @author Yaroslav Fedan <yaroslav.fd@gmail.com>
 * @link https://github.com/YaroslavFedan
 */
class ActiveRecordAsArrayHelper extends CActiveRecord
{
    protected $_as_array = false;

    public function as_array() {
        $this->_as_array = true;
        return $this;
    }

    protected function query($criteria,$all=false)
    {
        $this->beforeFind();
        $this->applyScopes($criteria);
        $command=$this->getCommandBuilder()->createFindCommand($this->getTableSchema(),$criteria);

        if ( $this->_as_array === true )
            return $all ? $command->queryAll() : $command->queryRow();
        else
            return $all ? $this->populateRecords($command->queryAll()) : $this->populateRecord($command->queryRow());
    }
}