<script type="text/javascript">
    $(document).ready(function () {
        $('#file_upload').uploadify({
            'buttonText': 'กรุณาเลือกรูปภาพ ...',
            'auto': true, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('backend/menu_system/upload_images_system/' . $system_id) ?>', //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
            'fileSizeLimit': '10MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
            'width': '350',
            'height': '40',
            'fileTypeExts': '*.gif; *.jpg; *.png; *.JPG;', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
            'multi': true, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
            'queueSizeLimit': 1, //อัพโหลดได้ครั้งละ 5 ไฟล์
            'onUploadComplete': function (success) { //เมื่ออัพโหลดเสร็จแล้วให้เรียกใช้งาน function load()
                window.location = "<?= site_url('takmoph_admin/get_menu_system/') ?>";
            }
        });
    });
</script>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'takmoph_admin', 'label' => 'หน้าหลัก'),
    array('url' => 'takmoph_admin/get_menu_system', 'label' => 'ระบบงาน/ลิงค์ภายนอก'),
        //array('url' => '', 'label' => 'menu2')
);

$active = $head;
?>
<div class="row" style=" margin: 0px; padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 0px;">
        <h3 id="head_submenu"><i class="fa fa-list-alt"></i> <?php echo $head ?></h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-right: 0px;">
        <?php echo $model->breadcrumb_backend($list, $active); ?>
    </div>
</div>

<hr id="hr"/>
<h4>เรื่อง :: <?php echo $title; ?></h4><br/>
<div class="row">
    <div class="col-md-6 col-lg-6">
        อัพโหลดได้ไม่เกินครั้งละ 10MB,<br/>
        อัพโหลดได้ไม่เกินครั้งละ 1 ไฟล์ ขนาด 200 x 100 px
        <br /><br />
        <form>
            <div id="queue"></div>
            <div style="width:350px;">
                <input id="file_upload" name="file_upload" type="file" multiple>
            </div>
        </form>
    </div>

    <div class="col-md-6 col-lg-6">
        <?php if (!empty($images)) { ?>
            <center>
                <img src="<?php echo base_url(); ?>icon_menu/<?php echo $images; ?>" class="img-responsive" style=" max-height: 150px;"/>
            </center>
        <?php } ?>
    </div>
</div>





