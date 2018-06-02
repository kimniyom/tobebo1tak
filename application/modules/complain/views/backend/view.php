<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array("label" => 'ร้องเรียน', 'url' => 'complain/backend')
);
$active = $head;
?>

<?php echo $model->breadcrumb_backend($list, $active); ?>

<h3 id="head_submenu">
    <i class="fa fa-file-text-o fa-2x text-warning"></i>
    <?php echo $datas->head_complain; ?>
</h3>
<hr/>

<button type="button" onclick="prints('page')" class="pull-right"><i class="fa fa-print"></i> print</button>

<p style="font-size: 16px;">
    <b>ผู้ร้องเรียน : </b> <?php echo $datas->name; ?> <br/>
    <b>วันที่ / เวลา : </b> <?php echo $model->thaidate($datas->d_update); ?><br/>
    <b>โทรศัพท์ : </b> <?php echo $datas->tel; ?><br/>
    <b>อีเมล์ : </b><?php echo $datas->email; ?><br/>
    <b>บัตรประชาชน : </b><?php echo $datas->card; ?>
</p>
<br/>
<div id="page">
    <div class="panel panel-default">
        <div class="panel-body">
            <h4>หัวข้อ : <?php echo $datas->head_complain; ?></h4>
            <hr/>
            <?php echo $datas->detail ?>
            <div id="show_images"></div>
        </div>
    </div>
    <br/>IP:<?php echo $datas->ip; ?>
</div>
<script type="text/javascript">
    getimages();
    function getimages() {
            var complain_id = "<?php echo $datas->id ?>";
            var url = "<?php echo site_url('complain/Getimages') ?>";
            var data = {complain_id: complain_id};
            $.post(url, data, function (result) {
                $("#show_images").html(result);
            });
        }
</script>
