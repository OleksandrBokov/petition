<div class="page pet_page">
    <div class="container">
        <!--section!-->
        <section class="page_columns">
            <div class="row">
                <h1><?php echo ($petition ? $petition->title : 'Петиція ще не створена'); ?></h1>
                <?php if($petition): ?>
                <!--left!-->
                <div class="page_left col-xs-8">
                    <!--pet_tabs!-->
                    <div class="pet_tabs">
                        <div id="pet-tab" class="tabs">
                            <ul class="tabs_list">
                                <?php ?>
                                <li class="tabs_child"><a class="tabs_link" <?php echo !empty($petition->petitionAnswers) ? '': 'disabled="&quot;disabled&quot;"'; ?> data-id="pet-tab-2" href="javascript:;">Відповідь на петицію</a></li>
                                <li class="tabs_child active"><a class="tabs_link" data-id="pet-tab-1" href="javascript:;">Текст петиції</a></li>
                                <li class="tabs_child"><a class="tabs_link" data-id="pet-tab-3" href="javascript:;">Підписалися</a></li>
                            </ul>
                        </div>
                        <div data-parent-id="pet-tab" id="pet-tab-2" class="tab_container">
                            <?php
                            if(!empty($petition->petitionAnswers)){
                                echo $petition->petitionAnswers->answer;
                            }
                            ?>
                        </div>
                        <div data-parent-id="pet-tab" id="pet-tab-1" class="tab_container active">
                            <div class="article">
                                <?php echo $petition->full_text; ?>
                            </div>
                        </div>
                        <div data-parent-id="pet-tab" id="pet-tab-3" class="tab_container">
                            <div class="users_table">
                                <div class="table_title">Перелік осіб які підписали електронну петицію</div>
                                <div class="table">
                                    <?php
                                    $i = 0;
                                    $this->widget('zii.widgets.grid.CGridView', array(
                                        'id'=>'petition-grid',
                                        'itemsCssClass' => 'table',
                                        'cssFile' => false,
                                        'hideHeader'=>true,
                                        'dataProvider'=>$dataProvider,
                                        'rowCssClassExpression' => ' ',
                                        'pager'=> array(
                                            'header' => false,
                                            'firstPageLabel' => false,
                                            'lastPageLabel'  => false,
                                            'prevPageLabel' => '&laquo; ',
                                            'nextPageLabel' => ' &raquo;',
                                            'maxButtonCount' => 4,
                                            'htmlOptions' => array(
                                                'class' => 'pagination'
                                            ),
                                        ),
                                        'template' => '{items}{summary}{pager}',
                                        'columns'=>array(
//                                            array(
//                                                'header'=>false,
//                                                'filter'=>false,
//                                                'value'=> '$data->id . "."',
//                                                'htmlOptions'=>array('class'=>'table_cell number'),
//                                                'cssClassExpression' => '',
//                                            ),
                                            array(
                                                'class'=>'IndexColumn',
                                                'htmlOptions'=>array('class'=>'table_cell number'),
                                                'cssClassExpression' => '',
                                            ),
                                            array(
                                                'header'=>false,
                                                'filter'=>false,
                                                'value'=>'$data->lastName." ".$data->firstName." ".$data->patronymic',
                                                'htmlOptions'=>array('class'=>'table_cell name'),
                                                'cssClassExpression' => '',
                                            ),
                                            array(
                                                'header'=>false,
                                                'filter'=>false,
                                                'value'=>'DateHelper::convertTimeStamp($data->date_registration,"d-m-Y")',
                                                'htmlOptions'=>array('class'=>'table_cell date'),
                                                'cssClassExpression' => '',
                                            )
                                        )
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--pet_tabs!-->
                </div>
                <!--left!-->
                <!--right!-->
                <div class="page_right col-xs-4">
                    <div class="petition_votes_wijet">
                        <div class="petition_votes">
                            <div style="color:green" class="petition_votes_graph" id="petition_votes_graph" data-votes="28">
                                <canvas id="votes_graph" width="170" height="170"></canvas>
                            </div>
                            <div class="petition_votes_txt">
                                <span><?php echo $dataProvider->totalItemCount; ?></span> <br>
                                голосів з 25000 <br>
                                необхідних
                            </div>
                        </div>
                        <div class="petition_votes_status">
                            <span class="votes_status_label">Статус:</span>
                            <?php
                            //$petition->date_create = strtotime('@'.$petition->date_create . '+ 90 days');
                            $now = DateHelper::getCurrentDateTimeToTimestamp();
                            $endDay = strtotime('@'.$petition->date_create . '+ 90 days');

                            //                            echo '<br>';
                            //                            echo 'segodnya '.date('Y-m-d H:i:s',$now);
                            //                            echo '<br>';
                            //                            echo 'data sozdaniya '.date('Y-m-d H:i:s',$petition->date_create);
                            //                            echo '<br>';
                            //                            echo 'data konca '.date('Y-m-d H:i:s',$endDay);
                            //                            echo '<br>';
                            ?>
                            <?php if($now <= $endDay):?>
                                Триває збір підписів
                            <?php else: ?>
                                <span>Збір підписів завершено</span>
                            <?php endif; ?>

                        </div>
                        <div class="petition_votes_progress">
                            <div class="votes_progress_label">
                                Залишилося
                                <?php echo $now > $endDay ? '0' : date_diff(new DateTime(date('Y-m-d H:i:s',$endDay)), new DateTime(date('Y-m-d H:i:s',$now)))->days; ?>
                                днів
                            </div>
                        </div>
                        <?php
                        //                        echo "<pre>";
                        //                        print_r($now);
                        //                        echo "</pre>";
                        //                        echo "<pre>";
                        //                        print_r($endDay);
                        //                        echo "</pre>";
                        //                        echo "<pre>";
                        //                        var_dump($now <= $endDay);
                        //                        echo "</pre>";
                        ?>
                        <div class="votes" id="votes">
                            <?php if($now > $endDay): ?>
                                <!--                            Збір підписів завершено-->
                            <?php elseif(Yii::app()->user->role === User::ROLE_MODERATOR && Yii::app()->user->status == User::STATUS_MODERATOR): ?>
                                <a href="<?php echo Yii::app()->createUrl('/moderator/changestatus')?>" class="btn btn-success" ><?php echo Yii::t('main','підпісати петицію')?></a>
                            <?php elseif(Yii::app()->user->role === User::ROLE_USER || Yii::app()->user->role === User::ROLE_MODERATOR): ?>
                                <div class="vote-mssg">Ваш підпис зараховано</div>
                            <?php else: ?>
                                <a href="<?php echo Yii::app()->createUrl('/user/registration')?>" class="btn btn-success" ><?php echo Yii::t('main','підпісати петицію')?></a>
                            <?php endif; ?>
                        </div>

                    </div>
                    <div class="petition_share_wijet">
                        <div class="share_wijet_url">
                            <a href="#" onclick="return false;" id="copy_clipboard" class="share_wijiet_urllink">Скопіювати url петиції</a>
                            <textarea id="tAText" style="opacity:0;width: 0;height: 0;padding: 0;margin: 0;overflow: hidden;max-height: 0;min-height: 0;"></textarea>
                            <div id="copy_done" class="popup-container">
                                <div class="popup">
                                    <div class="popup-content petition-content">
                                        <div class="popup-title"><i style="color:green;font-size: 2.25rem;" class="fa fa-check-circle-o"></i>&nbsp;Копіювання виконано!</div>
                                        <button data-popup-close="" class="popup_btn" type="button">Добре</button>
                                        <a href="javascript;;" data-popup-close="" class="popup-close"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div
            </div>
            <!--right!-->
            <?php endif; ?>
    </div>
    </section>
    <!--section!-->
</div>
</div>