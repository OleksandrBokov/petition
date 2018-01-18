<li>
    <lable><?php echo Yii::t('main', $data->label) ?></lable>
    <?php
        switch ($data->type){
            default:
                echo ($data->value) ? $data->value : $data->default;
        }
    ?>
</li>