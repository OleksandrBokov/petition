
<?php
$video = GalleryEntity::model()->getVideo($model->id);
if($video):
?>
<div class="with-min-block description-title">
    <div class="row description-item des">
        <div class="col-xs-12">
            <p class="name sm">видеообзор</p>
            <?php
            foreach ($video as $item):
                $item = explode('/', $item['item']);
                $src = end($item);
            ?>
            <div class="watch-video">
                <iframe width="100%" height="500" src="https://www.youtube.com/embed/<?=$src;?>" frameborder="0" allowfullscreen=""></iframe>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<?php endif;?>