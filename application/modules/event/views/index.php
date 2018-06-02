
<style type="text/css">
    #calendar{
        max-width: 100%;
        margin: 0 auto;
        font-size:16px;
    }       
</style>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = "";

$active = $head;
?>

<?php echo $model->breadcrumb($list, $active); ?>
<h3 id="head_submenu"><i class="fa fa-calendar"></i> <?php echo $head ?></h3>
<hr id="hr"/>

<div style="margin:auto;width:100%;">
    <div id='calendar'></div>
</div>


<!-- Update Event -->
<div class="modal fade" tabindex="-1" role="dialog" id="detailevent">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-calendar text-success"></i> กิจกรรม</h4>
            </div>
            <div class="modal-body" id="bodyevent">
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
                right: 'month,agendaWeek,agendaDay'
            },
            buttonIcons: {
                prev: 'left-single-arrow',
                next: 'right-single-arrow',
                prevYear: 'left-double-arrow',
                nextYear: 'right-double-arrow'
            },
            events: {
                url: 'index.php/event/getevent?gData=1',
                error: function () {

                }
            },
            eventLimit: true,
            lang: 'th'

        });

    });

    function detailevent(event_id) {
        var url = "<?php echo site_url('event/detailevent') ?>";
        var data = {event_id: event_id};
        $.post(url, data, function (datas) {
            $("#bodyevent").html(datas);
        });
        $("#detailevent").modal();
    }
</script>
