<style type="text/css">
    .t_box{ width:97%;}
</style>

<script type="text/javascript">
    $(document).ready(function () {
        loaddata();
        $('[data-toggle="tooltip"]').tooltip();

        $('#file_upload').uploadify({
            'buttonText': 'เลือกรูปภาพ ...',
            'auto': true, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('backend/photo/uoload_gallery/' . $album_id) ?>', //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
            'fileSizeLimit': '10MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
            //'width': '350',
            //'height': '40',
            'fileTypeExts': '*.gif; *.JPG; *.jpg; *jpeg; *.png', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
            'multi': true, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
            'queueSizeLimit': 10, //อัพโหลดได้ครั้งละ 5 ไฟล์
            'onUploadComplete': function (file, data, response) { //เมื่ออัพโหลดเสร็จแล้วให้เรียกใช้งาน function load()
                loaddata();
                if (response != "0") {
                    $("#log").append("Upload Images " + file.name + " Success <br/>");
                    $("#show_log").show();
                } else {
                    window.location = "<?php echo site_url('users/login') ?>";
                }
            }
        });
    });
</script>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
    array('url' => 'backend/photo/index', 'label' => 'อัลบั้ม/กิจกรรม'),
        //array('url' => 'backend/form_download/get_mas_from', 'label' => 'แบบฟอร์ม'),
);

$active = $head;
echo $model->breadcrumb_backend($list, $active);
?>

<h3><i class="fa fa-file-image-o"></i> <?= $head ?></h3>
<hr/>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
        <div class="container-card" style="height:200px;">
            <div class="img-wrapper">
                <img src="<?php echo base_url() ?>upload_images/photo/<?php echo $first_album ?>"
                     class="img-responsive"
                     style="height:200px;"/>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-9 col-lg-9">
        <h4>ชื่ออัลบั้ม <?php echo $album->title ?></h4><br/>
        รายละเอียด <?php
        if (!empty($album->detail)) {
            echo $album->detail;
        } else {
            echo "-";
        }
        ?><br/>
        ผู้สร้าง <?php echo $album->name . " " . $album->lname ?><br/><br/>
        วันที่ <?php echo $this->takmoph_libraries->thaidate($album->create_date) ?><br/>
    </div>
</div>

<hr/>
<!-- Add Icon -->

อัพโหลดได้ไม่เกินครั้งละ 10 mb<br/>
อัพโหลดได้ไม่เกินครั้งละ 10 ไฟล์<br/><br/>
นามสกุลไฟล์ gif jpg png
<br /><br />
<p style="color: #ff0000;">* หมายเหตุขนาดไฟล์อัพโหลดขึ้นอยู่กับการรับโหลดที่ server ด้วย</p>
<form>
    <div id="queue"></div>
    <div style="width:350px;">
        <input id="file_upload" name="file_upload" type="file" multiple>
    </div>
</form>

<div class="alert alert-success" data-dismiss="alert" id="show_log">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <label>Result</label>
    <hr/>
    <div id="log"></div>
</div>

<div id="gallery"></div>

<script type="text/javascript">
    function loaddata() {
        var url = "<?php echo site_url('backend/photo/get_gallery') ?>";
        var album_id = "<?php echo $album_id ?>";
        var data = {album_id: album_id};

        $.post(url, data, function (success) {
            $("#gallery").html(success);
        });
    }
</script>
