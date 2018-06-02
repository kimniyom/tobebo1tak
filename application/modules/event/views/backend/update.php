<div class="row">
    <div class="col-md-3 col-lg-3">
        <center>
            <img src="<?php echo base_url() ?>assets/module/event/images/icon.png" class="img-responsive"/><br/>
            วันที่ / เวลา<br/>
            <?php
            echo "เริ่ม : ".$this->takmoph_libraries->thaidate($event->event_start) . "<br/>สิ้นสุด : " . $this->takmoph_libraries->thaidate($event->event_end);
            ?>
            <hr/>
            สีกิจกรรม
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-danger <?php if ($event->event_color == "#d60000") { echo "active"; } ?>">
                    <input type="radio" name="_event_color" id="_event_color" autocomplete="off" <?php if ($event->event_color == "#d60000") { echo "checked"; } ?> value="#d60000"> แดง
                </label>
                <label class="btn btn-success <?php if ($event->event_color == "#156e00") { echo "active"; } ?>">
                    <input type="radio" name="_event_color" id="_event_color" autocomplete="off" <?php if ($event->event_color == "#156e00") { echo "checked"; } ?> value="#156e00"> เขียว
                </label>
                <label class="btn btn-warning <?php if ($event->event_color == "#d9ae02") { echo "active"; } ?>">
                    <input type="radio" name="_event_color" id="_event_color" autocomplete="off" <?php if ($event->event_color == "#d9ae02") { echo "checked"; } ?> value="#d9ae02"> เหลือง
                </label>
            </div>
        </center>
    </div>
    <div class="col-md-9 col-lg-9">
        <input type="hidden" id="event_id" value="<?php echo $event->event_id ?>"/>
        <label>* หัวข้อ / เรื่อง</label>
        <input type="text" id="_event_title" class="form-control" value="<?php echo $event->event_title ?>"/>
        <div class="row">
            <div class='col-md-6'>
                <label>* ระหว่างวันที่</label>
                <div class="form-group">
                    <div class='input-group date' id='datetimepickerstart'>
                        <input type='text' class="form-control" id="_event_start" value="<?php echo $event->event_start ?>"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <label>* ถึงวันที่</label>
                <div class="form-group">
                    <div class='input-group date' id='datetimepickerend'>
                        <input type='text' class="form-control" id="_event_end" value="<?php echo $event->event_end ?>"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <label>รายละเอียด</label>
        <textarea class="form-control" id="_event_detail" rows="5"><?php echo $event->event_detail ?></textarea>
        <label>ผู้บันทึกกิจกรรม</label>
        <input type="text" id="_event_author" class="form-control" readonly="readonly" value="<?php echo $event->event_author ?>"/>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#datetimepickerstart').datetimepicker({
            format: 'YYYY-MM-DD HH:mm'
        });
        $('#datetimepickerend').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            useCurrent: false //Important! See issue #1075
        });
        $("#datetimepickerstart").on("dp.change", function (e) {
            $('#datetimepickerend').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepickerend").on("dp.change", function (e) {
            $('#datetimepickerstart').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>