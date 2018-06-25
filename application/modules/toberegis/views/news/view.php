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
        SetImgResponsive(".detail-new");
        Settitleimg();
    });

    function SetImgResponsive(BoxID) {
        var BoxPost = BoxID;
        var tn_array = $(BoxPost + ' img').map(function () {
            return $(this).attr("id");
        });

        for (var i = 0; i < tn_array.length; i++) {
            var tagimg = tn_array[i];
            var widthimg = $(BoxPost).width();
            var img = $(BoxPost + " #" + tagimg).width();
            if (img >= widthimg) {
                $(BoxPost + " #" + tagimg).addClass("img-responsive");
                $(BoxPost + " #" + tagimg).css({"width": "auto", "height": "auto"});
            }
        }

    }

    function Settitleimg() {
        var firstIMG = "<?php echo $firstIMG ?>";
        if (firstIMG != "") {
            var img = document.getElementById('img-new');
            var widthIMG = img.clientWidth;
            var widthbox = $(".detail-new").width();
            if (widthIMG >= widthbox) {
                $("#img-new").addClass("img-responsive");
            } else {
                $("#img-new").css({"width": "auto", "height": "auto"});
            }
        }
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        show_album_news();
        $('#file_upload').uploadify({
            'buttonText': 'กรุณาเลือกรูปภาพ ...',
            'auto': true, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('toberegis/news/upload_images_news/' . $news->id) ?>', //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
            'fileSizeLimit': '10MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
            'fileTypeExts': '*.gif; *.jpg; *.JPG;', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
            'multi': true, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
            'queueSizeLimit': 5, //อัพโหลดได้ครั้งละ 5 ไฟล์
            'onUploadComplete': function (success) { //เมื่ออัพโหลดเสร็จแล้วให้เรียกใช้งาน function load()
                show_album_news();
            }
        });
    });

    function show_album_news() {
        var news_id = "<?php echo $news->id ?>";
        var url = "<?php echo site_url('toberegis/news/album_news') ?>";
        var data = {news_id: news_id};
        $.post(url, data, function (result) {
            $("#show_alum_news").html(result);
        });
    }

    function delete_news(news_id) {
        var r = confirm("Are you sure ...?");
        if (r == true) {
            var url = "<?php echo site_url('toberegis/news/delete_news'); ?>";
            var data = {news_id: news_id};
            $.post(url, data, function (success) {
                window.location = "<?php echo site_url('toberegis/news/index') ?>";
            });
        }
    }

</script>


<?php
$this->load->library('takmoph_libraries');

$model = new takmoph_libraries();

$list = array(
   array('url' => 'toberegis/news/index', 'label' => 'ข่าวประชาสัมพันธ์'),
);
$active = $head;
$eid = $this->takmoph_libraries->url_encode($this->session->userdata('tobe_user_id'));
echo $model->breadcrumb_backend($list, $active, 'toberegis/users/detailuser/' . $eid);
?>

<div class="well" style=" clear: both;">
    <div class="pull-right">
        <a href="<?php echo site_url('toberegis/news/update/' . $news->id) ?>">
            <button type="button" class="btn btn-default"><i class="fa fa-pencil"></i> แก้ไข</button></a>
        <button type="button" class="btn btn-default" onclick="javascript:delete_news('<?php echo $news->id ?>')"><i class="fa fa-trash"></i> ลบ</button>
    </div>   
    <h3 style=" margin-top: 0px;"><?php echo $news->title; ?></h3>
    <hr/>
    <div class="img-new">
        <?php if ($firstIMG) { ?>
            <img src="<?php echo base_url() ?>upload_images/news/<?php echo $firstIMG ?>" id="img-new"/>
        <?php } ?>
    </div>
    <br/>
    <div class="detail-new">
        <?php echo $news->detail; ?>
    </div>
    วันที่ : <?php echo $model->thaidate($news->date) ?><br/>
    <?php if ($news->qrcode) { ?>
        <img src="<?php echo base_url() ?>qrcode/<?php echo $news->qrcode ?>" width="100"/>
    <?php } ?>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><h4>อัลบั้มรูปภาพ</h4></div>
    <div class="panel-body">
        <font style=" font-size: 12px; color: #cc0033;">
        อัพโหลดได้ไม่เกินครั้งละ 5MB,<br/>
        อัพโหลดได้ไม่เกินครั้งละ 5 ไฟล์
        </font>
        <form>
            <div style="width:350px;">
                <input id="file_upload" name="file_upload" type="file" multiple>
            </div>
        </form><br />
        <div class="well" style="background: #FFF;" id="show_alum_news"></div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
        //FANCYBOX
        $(".fancybox").fancybox({
            openEffect: "none",
            closeEffect: "none"
        });
    });
</script>


