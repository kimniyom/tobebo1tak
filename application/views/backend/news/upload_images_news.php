
<style type="text/css">
    .thumbnail {
        position: relative;
        width: 200px;
        height: 200px;
        overflow: hidden;
    }
    .thumbnail img {
        position: absolute;
        left: 50%;
        top: 50%;
        height: 100%;
        width: auto;
        -webkit-transform: translate(-50%,-50%);
        -ms-transform: translate(-50%,-50%);
        transform: translate(-50%,-50%);
    }
    .thumbnail img.portrait {
        width: 100%;
        height: auto;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        show_album_news();
        $('#file_upload').uploadify({
            'buttonText': 'กรุณาเลือกรูปภาพ ...',
            'auto': true, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('backend/news/upload_images_news/' . $new_id) ?>', //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
            'fileSizeLimit': '10MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
            /*
            'width': '350',
            'height': '40',
            */
            'fileTypeExts': '*.gif; *.jpg; *.png; *.JPG;', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
            'multi': true, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
            'queueSizeLimit': 10, //อัพโหลดได้ครั้งละ 5 ไฟล์
            'onUploadComplete': function (success) { //เมื่ออัพโหลดเสร็จแล้วให้เรียกใช้งาน function load()
                show_album_news();
            }
        });
    });

    function show_album_news() {
        var news_id = "<?php echo $new_id ?>";
        var url = "<?php echo site_url('backend/news/album_news') ?>";
        var data = {news_id: news_id};
        $.post(url, data, function (result) {
            $("#show_alum_news").html(result);
        });
    }

</script>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
    array('url' => 'backend/groupnews/index', 'label' => 'กลุ่มข่าวประชาสัมพันธ์'),
    array('url' => 'backend/news/get_news/' . $groupnews->id, 'label' => $groupnews->groupname)
);

$active = $head;
echo $model->breadcrumb_backend($list, $active);
?>
<h3><i class="fa fa-image"></i> <?= $head ?></h3>
<h4 class="text-success">:: <?php echo $news->titel; ?></h4>
<hr/>

อัพโหลดได้ไม่เกินครั้งละ 10MB,<br/>
อัพโหลดได้ไม่เกินครั้งละ 10 ไฟล์
<br /><br />
<form>
    <div id="queue"></div>
    <div style="width:350px;">
        <input id="file_upload" name="file_upload" type="file" multiple>
    </div>
</form><br /><br /><br />

<h4>อัลบั้มรูปภาพ</h4>
<div class="well" style=" background: #FFF;" id="show_alum_news"></div>
