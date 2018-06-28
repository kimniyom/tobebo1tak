<?php if ($news->num_rows() > 0) { ?>
    <div style="font-size:24px; font-weight: bold;">
        <i class="fa fa-trophy"></i> 10 ลำดับล่าสุด
    </div>
    <div class="list-group" style="margin:0px; padding: 0px; border: none;">
        <?php
        foreach ($news->result() as $newstobe):
            ?>
            <a href="<?php echo site_url('toberegis/tobenews/view/' . $this->takmoph_libraries->url_encode($newstobe->id) . '/' . $newstobe->type) ?>" class="list-group-item" style="margin:0px; padding: 0px; border: none;">
                <i class="fa fa-calendar"></i> <?php echo $newstobe->date ?>
                <b><?php echo $newstobe->title ?></b>
            </a>
        <?php endforeach; ?>
    </div>
    <hr/>
    <a href="<?php echo site_url('toberegis/tobenews/newsall/' . $this->takmoph_libraries->url_encode($type)) ?>"
       <button type="button" class="btn btn-warning btn-xs pull-right">ทั้งหมด ...</button></a>
<?php } else { ?>
    <center>ไม่มีข้อมูล</center>
<?php } ?>

