<!-- Upload -->
<script src="<?= base_url() ?>lib/js/jquery.uploadify-3.1.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>lib/css/uploadify.css">
<script type="text/javascript">
    getimages();
    $(document).ready(function () {
        $('#file_upload').uploadify({
            'buttonText': 'เพิ่มรูปภาพ ...',
            'auto': true, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('complain/upload_images/' . $complain->id) ?>', //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
            'fileSizeLimit': '10MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
            //'width': '350',
            //'height': '40',
            'fileTypeExts': '*.gif; *.jpg; *.png; *.JPG;', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
            'multi': true, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
            'queueSizeLimit': 3, //อัพโหลดได้ครั้งละ 5 ไฟล์
            'onUploadComplete': function (success) { //เมื่ออัพโหลดเสร็จแล้วให้เรียกใช้งาน function load()
                getimages();
            }
        });
    });


    function getimages() {
        var complain_id = "<?php echo $complain->id ?>";
        var url = "<?php echo site_url('complain/Getimages') ?>";
        var data = {complain_id: complain_id};
        $.post(url, data, function (result) {
            $("#show_images").html(result);
        });
    }

    function delete_complain(id) {
        var url = "<?php echo site_url('complain/delet') ?>";
        var data = {id: id};

        var r = confirm("คถณต้องการลบข้อมูลนี้ ใช่ หรือ ไม่");
        if (r == true) {
            $.post(url, data, function (success) {
                window.location = "<?php echo site_url('') ?>";
            });
        }
    }
</script>

<ul class="breadcrumb">
    <li>
        <a href="<?php echo site_url('complain/view') ?>">
            <i class="icon icon-home"></i> หน้าร้องเรียน</a> 

    </li>
    <li class="active">รายละเอียด</li>
</ul>

<h3 id="head_submenu"><?php echo $head; ?></h3>
<div class="well" style=" position: relative; background: #FFF;">
    <a href="<?php echo site_url('complain/success')?>">
    <div class="btn btn-success btn-xs" style=" position: absolute; top: 5px; right: 60px;">
        <i class="fa fa-check"></i> ยืนยัน
    </div></a>
    
    <div class="btn btn-danger btn-xs" style=" position: absolute; top: 5px; right: 5px;"
         onclick="delete_complain('<?php echo $complain->id ?>');">
        <i class="fa fa-trash-o"></i> ลบ
    </div>
    
    <h4>
        หัวข้อ : <?php echo $complain->head_complain; ?>
    </h4>
    <hr>
    <?php echo $complain->detail; ?>
    <hr/>
    <form>
        <div id="queue"></div>
        <div style="width:350px;">
            <input id="file_upload" name="file_upload" type="file" multiple>
        </div>
    </form><br /><br />
    <div id="show_images"></div>


    <hr>
    <div class="alert alert-danger">
        ผู้ร้องเรียน : <?php echo $complain->name; ?> | 
        เวลา : <?php echo $this->tak->thaidate($complain->d_update); ?> | 
        IP : <?php echo $complain->ip; ?><br/>
    </div>
</div>