
<style type="text/css">
    #calendar{
        max-width: 100%;
        margin: 0 auto;
        font-size:16px;
    }       
</style>

<?php
$this->load->library('takmoph_libraries');
$lib = new takmoph_libraries();
$model = new takmoph_libraries();
$list = "";

$active = $head;
?>
<div class="row" style=" margin: 0px; padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 0px;">
        <h3 id="head_submenu"><i class="fa fa-calendar"></i> <?php echo $head ?></h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-right: 0px;">
        <?php echo $model->breadcrumb_backend($list, $active); ?>
    </div>
</div>

<hr id="hr"/>



<div class="row">
    <div class="col-md-3 col-lg-3">
        <?php $this->load->view('backend/menu') ?>
    </div>
    <div class="col-md-9 col-lg-9">
        <div style="margin:auto;width:100%;" id="log">
            <div id='calendar'></div>
        </div>
    </div>
</div>

<!-- Add Event -->
<div class="modal fade" tabindex="-1" role="dialog" id="popupaddevent">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-calendar text-success"></i> เพิ่มกิจกรรม</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3 col-lg-3">
                        <center>
                            <img src="<?php echo base_url() ?>assets/module/event/images/icon.png" class="img-responsive"/><br/>
                            <p id="thaidate"></p>
                            สีกิจกรรม
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-danger active">
                                    <input type="radio" name="event_color" id="event_color" autocomplete="off" checked value="#d60000"> แดง
                                </label>
                                <label class="btn btn-success">
                                    <input type="radio" name="event_color" id="event_color" autocomplete="off" value="#156e00"> เขียว
                                </label>
                                <label class="btn btn-warning">
                                    <input type="radio" name="event_color" id="event_color" autocomplete="off" value="#d9ae02"> เหลือง
                                </label>
                            </div>
                        </center>
                    </div>
                    <div class="col-md-9 col-lg-9">
                        <input type="hidden" id="event_date" class="form-control"/>
                        <label>* หัวข้อ / เรื่อง</label>
                        <input type="text" id="event_title" class="form-control"/>

                        <div class="row">
                            <div class='col-md-6'>
                                <label>* ระหว่างวันที่</label>
                                <div class="form-group">
                                    <div class='input-group date' id='datetimepicker6'>
                                        <input type='text' class="form-control" id="event_start"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <label>* ถึงวันที่</label>
                                <div class="form-group">
                                    <div class='input-group date' id='datetimepicker7'>
                                        <input type='text' class="form-control" id="event_end"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label>รายละเอียด</label>
                        <textarea class="form-control" id="event_detail" rows="5"></textarea>
                        <label>ผู้บันทึกกิจกรรม</label>
                        <input type="text" id="event_author" class="form-control" readonly="readonly" value="<?= $this->session->userdata('name') . ' ' . $this->session->userdata('lname') ?>"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="Addevent()">บันทึก</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Update Event -->
<div class="modal fade" tabindex="-1" role="dialog" id="updateevent">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-calendar text-success"></i> กิจกรรม</h4>
            </div>
            <div class="modal-body" id="bodyupdateevent">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="SaveUpdateEvent()" style=" border-color: #ffcc00;"><i class="fa fa-pencil text-warning"></i> แก้ไข</button>
                <button type="button" class="btn btn-default" onclick="DeleteEvent()" style=" border-color: #ff3300;"><i class="fa fa-trash-o text-danger"></i> ลบ</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today', //  prevYear nextYea
                center: 'title',
                //right: 'month,agendaWeek,agendaDay'
                right: ''
            },
            buttonIcons: {
                prev: 'left-single-arrow',
                next: 'right-single-arrow',
                prevYear: 'left-double-arrow',
                nextYear: 'right-double-arrow'
            },
            dayClick: function (date, jsEvent, view) {

                /*
                 alert('Clicked on: ' + date.format());
                 
                 alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                 
                 alert('Current view: ' + view.name);
                 */
                // change the day's background color just for fun
                //$(this).css('background-color', 'red');
                /*
                 $("#popupaddevent").modal();
                 $("#event_date").val(date.format());
                 var url = "<?//php echo site_url('event/backend/thaidate') ?>" + "/" + date.format();
                 $("#thaidate").load(url);
                 */
            },
            events: {
                url: '<?php echo site_url('event/backend/getevent?gData=1') ?>',
                error: function () {

                }
            },
            eventLimit: true,
            lang: 'th'

        });

        $('#datetimepicker6').datetimepicker({
            format: 'YYYY-MM-DD HH:mm'
        });
        $('#datetimepicker7').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            useCurrent: false //Important! See issue #1075
        });
        $("#datetimepicker6").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });


    });

    function popupAddevent() {
        $("#popupaddevent").modal();
    }

    function Addevent() {
        var event_title = $("#event_title").val();
        var event_detail = $("#event_detail").val();
        var event_author = $("#event_author").val();
        var event_start = $("#event_start").val();
        var event_end = $("#event_end").val();
        var color = $('input[name=event_color]:checked').val();
        if (event_title == "" || event_start == "" || event_end == "") {
            alert("กรุณากรอกช่องเครื่องหมาย * ...!");
            return false;
        }
        var url = "<?php echo site_url('event/backend/addevent') ?>";
        var data = {
            event_title: event_title,
            event_detail: event_detail,
            event_author: event_author,
            event_start: event_start,
            event_end: event_end,
            event_color: color,
            event_allDay: true
        };
        $.post(url, data, function (datas) {
            window.location.reload();
        });
    }

    function updateevent(event_id) {
        var url = "<?php echo site_url('event/backend/updateevent') ?>";
        var data = {event_id: event_id};
        $.post(url, data, function (datas) {
            $("#bodyupdateevent").html(datas);
        });
        $("#updateevent").modal();
    }

    function SaveUpdateEvent() {
        var event_id = $("#event_id").val();
        var event_title = $("#_event_title").val();
        var event_detail = $("#_event_detail").val();
        var event_start = $("#_event_start").val();
        var event_end = $("#_event_end").val();
        var event_author = $("#_event_author").val();
        var color = $('input[name=_event_color]:checked').val();
        if (event_title == "" || event_start == "" || event_end == "") {
            alert("กรุณากรอกช่องเครื่องหมาย * ...!");
            return false;
        }
        var url = "<?php echo site_url('event/backend/saveupdateevent') ?>";
        var data = {
            event_id: event_id,
            event_title: event_title,
            event_detail: event_detail,
            event_author: event_author,
            event_start: event_start,
            event_end: event_end,
            event_color: color,
            event_allDay: true
        };
        $.post(url, data, function (datas) {
            window.location.reload();
        });
    }

    function DeleteEvent() {
        var event_id = $("#event_id").val();
        var r = confirm('Are you sure ..?');
        var url = "<?php echo site_url('event/backend/deleteevent') ?>";
        var data = {event_id: event_id};
        if (r == true) {
            $.post(url, data, function (datas) {
                window.location.reload();
            });
        }
    }
    
    function Log(){
        var url = "<?php echo site_url('event/backend/log') ?>";
        $("#log").load(url);
    }
</script>
