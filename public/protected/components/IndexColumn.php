<?php

Yii::import('zii.widgets.grid.CGridColumn');

/**
 * Class IndexColumn
 */
class IndexColumn extends CGridColumn {

    public $sortable = false;

    public function init()
    {
        parent::init();
    }

    /**
     * @param int $row
     * @param mixed $data
     */
    protected function renderDataCellContent($row,$data)
    {
        $pagination = $this->grid->dataProvider->getPagination();
        $index = $pagination->pageSize * $pagination->currentPage + $row + 1;
        echo $index;
    }

}