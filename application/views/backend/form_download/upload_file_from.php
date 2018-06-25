<script type="text/javascript">
    $(document).ready(function () {
        $('#file_upload').uploadify({
            'buttonText': 'กรุณาเลือกไฟล์ ...',
            'auto': true, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('backend/form_download/file_upload_from/' . $from_id) ?>', //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
            'fileSizeLimit': '100MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
            'width': '350',
            'height': '40',
            'fileTypeExts': '*.zip; *.rar; *.ppt; *.pdf; *.doc;', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
            'multi': true, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
            'queueSizeLimit': 1, //อัพโหลดได้ครั้งละ 5 ไฟล์
            'onUploadComplete': function (success) { //เมื่ออัพโหลดเสร็จแล้วให้เรียกใช้งาน function load()
                window.location="<?php echo site_url('backend/form_download/get_mas_from')?>";
            }
        });
    });
</script>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
    array('url' => 'backend/form_download/get_mas_from', 'label' => 'แบบฟอร์ม'),
);

$active = "upload";
echo $model->breadcrumb_backend($list, $active);
?>

<h3><i class="fa fa-upload"></i> <?= $head ?></h3>

<hr/>
<h4>เรื่อง :: <?php echo $title ?></h4>

อัพโหลดได้ไม่เกินครั้งละ 100MB,<br/>
อัพโหลดได้ไม่เกินครั้งละ 1 ไฟล์<br/><br/>

นาสกุลไฟล์ *.zip; *.rar; *.ppt; *.pdf; *.doc
<br /><br />
<form>
    <div id="queue"></div>
    <div style="width:350px;">
        <input id="file_upload" name="file_upload" type="file" multiple>
    </div>
</form><br /><br /><br />
