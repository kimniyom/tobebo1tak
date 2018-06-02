<script type="text/javascript">
    $(document).ready(function () {
        SetImgResponsive(".detail-post");
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
</script>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = array(
    array("label" => $post->catname, "url" => 'asbforum/post/category/' . $post->category)
);
$active = $head;
?>

<?php echo $model->breadcrumb_backend($list, $active, "asbforum"); ?>

<br/><br/>
<div id="post" style=" border: #cccccc solid 1px; padding: 10px;">
    <div class="row">
        <div class="col-md-2 col-lg-2" style=" font-size: 12px;">
            <div style=" text-align: center;">
                <img src="<?php echo base_url() ?>assets/module/asbforum/uploads/<?php echo $users->photo ?>" class="img img-responsive" style=" width: 150px;"/>
            </div>
            โพสต์โดย  : <?php echo $users->alias ?><br/>
            วันที่ : <?php echo $model->thaidate($post->create_date) ?><br/>
            แก้ไขล่าสุด : <?php echo $model->thaidate($post->d_update) ?><br/>
            IP : <?php echo $post->ip ?>
        </div>
        <div class="col-md-10 col-lg-10">
            <div class="well">
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default btn-sm" onclick="postdelete()">
                        ลบ <i class="fa fa-trash-o text-danger"></i>
                    </button>
                    <a href="<?php echo site_url('asbforum/post/editpost/' . $post->id) ?>">
                        <button type="button" class="btn btn-default btn-sm">
                            แก้ไข <i class="fa fa-pencil text-warning"></i>
                        </button></a>
                </div>
                <h3><?php echo $post->title; ?></h3>
                <span class="badge">อ่าน <?php echo number_format($post->readpost) ?></span>
                <!-- Shaee FaceBook -->
                <div class="fb-share-button" data-layout="button_count"></div>
                <hr/>
                <div class="detail-post">
                    <?php echo $post->detail; ?>
                </div>

                <hr/>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    Getcaptcha();
    function Getcaptcha() {
        var url = "<?php echo site_url('asbforum/post/SetCaptcha') ?>";
        var data = {};
        $.post(url, data, function (datas) {
            $("#getcaptcha").html(datas);
        });
    }

    function openuploads() {
        loadimages();
        $("#popupdialog").modal();
    }

    function loadimages() {
        var url = "<?php echo site_url('asbforum/albumphoto/getalbum') ?>";
        var data = {};
        $.post(url, data, function (datas) {
            $("#img-uploads").html(datas);
        });
    }

    function Addcontent(img) {
        var url = "<?php echo base_url() ?>assets/module/asbforum/albumphoto" + "/" + img;
        var res = img.replace(".", "");
        var content = "<img src='" + url + "' style='width:500px;' id='img-comment" + res + "'/>";

        var detail = CKEDITOR.instances.comment.getData();
        CKEDITOR.instances.comment.setData(detail + content);
        $("#popupdialog").modal('hide');
    }

    function Comment() {
        var url = "<?php echo site_url('asbforum/post/comment') ?>";
        var post_id = "<?php echo $post->id ?>";
        var comment = CKEDITOR.instances.comment.getData();
        var captcha = $("#captcha").val();
        var recaptcha = $("#recaptcha").val();

        if (captcha != recaptcha) {
            alert("กรอกรหัสภาพไม่ถูกต้อง");
            return false;
        }

        if (comment == "") {
            $("#comment").focus();
            return false;
        }

        var data = {post_id: post_id, comment: comment};

        $.post(url, data, function (datas) {
            resetform();
            loadcomment();
        });
    }

    loadcomment();
    function loadcomment() {
        var url = "<?php echo site_url('asbforum/post/loadcomment') ?>";
        var post_id = "<?php echo $post->id ?>";
        var data = {post_id: post_id};
        $.post(url, data, function (datas) {
            $("#data-comment").html(datas);
        });
    }

    function resetform() {
        Getcaptcha();
        CKEDITOR.instances.comment.setData("");
        $("#captcha").val("");
    }

    function postdelete() {
        var url = "<?php echo site_url('asbforum/post/informpost') ?>";
        var post_id = "<?php echo $post->id ?>";
        var data = {post_id: post_id};
        $.post(url, data, function (datas) {
            $.notify({
                // options
                message: 'ระบบได้รับการแจ้งลบกระทู้ของท่านแล้ว'
            }, {
                // settings
                type: 'success',
                placement: {
                    from: "top",
                    align: "right"
                }
            });
        });
    }
</script>
