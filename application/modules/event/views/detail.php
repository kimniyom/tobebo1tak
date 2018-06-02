<div class="row">
    <div class="col-md-3 col-lg-3">
        <center>
            <img src="<?php echo base_url() ?>assets/module/event/images/icon.png" class="img-responsive"/><br/>
            วันที่ / เวลา<br/>
            <?php
            echo "เริ่ม : " . $this->takmoph_libraries->thaidate($event->event_start) . "<br/>สิ้นสุด : " . $this->takmoph_libraries->thaidate($event->event_end);
            ?>
        </center>
    </div>
    <div class="col-md-9 col-lg-9">
        <h3 id="font-thaisanslite">หัวข้อ / เรื่อง : <?php echo $event->event_title ?></h3>
        <h4 id="font-thaisanslite">รายละเอียด : <?php echo $event->event_detail ?></h4>
        <hr/>
        <label>ผู้บันทึกกิจกรรม : </label><?php echo $event->event_author ?><br/>
        <label>วันที่บันทึก : </label><?php echo $event->create_date ?><br/>
        <label>แก้ไขล่าสุด : </label><?php echo $event->d_update ?><br/>
    </div>
</div>
