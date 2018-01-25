<?php


class CheckBoxColumn extends CCheckBoxColumn
{
    /**
     * evaluate string for initial state
     * @var string
     */
    public $selected = '';
    public $htmlClass = '';
    public $filter = '';


    /**
     * Renders the data cell content.
     * This method renders a checkbox in the data cell.
     * @param integer the row number (zero-based)
     * @param mixed the data associated with the row
     */
    protected function renderDataCellContent($row,$data)
    {

        if($this->value!==null){
            $value=$this->evaluateExpression($this->value,array('data'=>$data,'row'=>$row));
        } else if($this->name!==null){
            $value=CHtml::value($data,$this->name);
        } else{
            $value=$this->grid->dataProvider->keys[$row];
        }

        $options=$this->checkBoxHtmlOptions;
        $options['value']=$value;
        $options['id']=$this->id.'_'.$row;

        $options['name'] = $this->name.'['.$data->id.']';
        $options['class'] = $this->htmlClass;
        echo CHtml::checkBox($options['name'], $this->evaluateExpression($this->selected,array('data'=>$data,'row'=>$row)), $options);
    }
}