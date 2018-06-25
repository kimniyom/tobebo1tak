<style type="text/css">
    .im-resize{ width: 85px; height: 48px;}
</style>
<div class="slider-box">
    <div id="slider-wrapper">
        <div id="jslider-container">
            <div class="jslider_images">
                <ul>
                    <?php 
                    $news = $this->tak->get_news_limit();
                    foreach($news->result() as $rs):
                    ?>
                    
                    <li>
                        <a href="<?= site_url('takmoph2014/show_detail_news/'.$rs->id) ?>">
                            <img src="<?= base_url() ?>upload_images/<?php echo $rs->images;?>" title=""/>
                        </a><?php echo $rs->titel;?>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div> 

            <div class="jslider_thumbs">
                <div>
                    <?php 
                    $news_t = $this->tak->get_news_limit();
                    foreach($news_t->result() as $rss):
                    ?>
                    <a href="#" title="Sunset"><img src="<?= base_url() ?>upload_images/<?php echo $rss->images;?>" class="im-resize"/></a>
                    <?php endforeach;?>
                </div>
            </div>

        </div>
    </div>
</div>
