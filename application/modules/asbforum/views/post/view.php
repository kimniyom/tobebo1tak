<style type="text/css">
    .modal.modal-wide .modal-dialog {
        width: 95%;
    }
    .modal-wide .modal-body {
        overflow-y: auto;
    }
</style>
<script src="<?= base_url() ?>assets/CK-Editor/ckeditor.js"></script>
<script>
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.5&appId=266256337158296";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

</script>

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

<script type="text/javascript">
    $(document).ready(function () {
        //loaddata();
        $('[data-toggle="tooltip"]').tooltip();
        $('#file_upload').uploadify({
            'buttonText': ' อัพโหลดรูปภาพ ...',
            'auto': true, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('asbforum/post/uoloads/') ?>', //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
            'fileSizeLimit': '1MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
            //'width': '350',
            //'height': '40',
            'fileTypeExts': '*.gif; *.JPG; *.jpg; *jpeg; *.png', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
            'multi': true, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
            'queueSizeLimit': 5, //อัพโหลดได้ครั้งละ 5 ไฟล์
            'onUploadComplete': function (file, data) { //เมื่ออัพโหลดเสร็จแล้วให้เรียกใช้งาน function load()
                loadimages();
            }
        });
    });
</script>
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = array(
    array("label" => $category_name, "url" => 'asbforum/post/category/' . $post->category)
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
                <!-- Single button -->
                <?php if (!empty($this->session->userdata('forum_user_id'))) { ?>
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-default btn-sm" onclick="postdelete()">
                            แจ้งลบ <i class="fa fa-trash-o"></i>
                        </button>
                    </div>
                <?php } ?>
                <h3><?php echo $post->title; ?></h3>
                <span class="badge">อ่าน <?php echo number_format($post->readpost) ?></span>
                <!-- Shaee FaceBook -->
                <div class="fb-share-button" data-layout="button_count"></div>

                <hr/>

                <?php if ($post->privilege == "1") { ?>
                    <?php if (!empty($this->session->userdata('forum_user_id'))) { ?>
                        <div class="detail-post"><?php echo $post->detail; ?></div>
                    <?php } else { ?>
                        <div class="alert alert-danger" style="text-align: center;">...เนื้อหาถูกซ่อนกรุณาเข้าสู่ระบบก่อน...</div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="detail-post">
                        <?php echo $post->detail; ?>
                    </div>
                    <hr/>
                <?php } ?>
                <hr/>


                <?php if (!empty($this->session->userdata('forum_user_id'))) { ?>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            CKEDITOR.replace('comment', {
                                //language: 'th',
                                //height: 500,
                                //uiColor: '#FFFFFF',
                                //{ name: 'document', items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
                                removePlugins: 'bidi,forms,flash,iframe,div,find',
                                removeButtons: 'Anchor,Underline,Strike,Subscript,Superscript,Editing,Templates,Preview,NewPage,Source,Save,Scayt,About,Print,Cut,Language,Table,HorizontalRule,SpecialChar,PageBreak,ShowBlocks,Cut,Copy,Paste,PasteText,PasteFromWord,-,Undo,Redo,SelectAll'
                            });
                        });
                    </script>
                    <h4>ความคิดเห็น :: </h4>
                    <div id="data-comment">

                    </div>
                    <h4>แสดงความคิดเห็น :: </h4>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <textarea class="form-control" id="comment" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="row" style=" margin-top: 10px;">
                        <div class="col-md-3 col-lg-3">
                            <button type="button" class="btn btn-default" onclick="openuploads()">
                                <i class="fa fa-photo"></i> แทรกรูปภาพ
                            </button>
                        </div>
                    </div>

                    <div class="row" style=" margin-top: 10px;">
                        <div class="col-md-12 col-lg-12">
                            <label>พิมพ์ตัวอักษรที่เห็นในรูปด้านล่าง</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-lg-3">
                            <div id="getcaptcha"></div>
                        </div>
                        <div class="col-md-2 col-lg-2" style="padding-top: 15px;">
                            <a href="javascript:Getcaptcha()"><i class="fa fa-refresh"></i></a></button>
                        </div>
                    </div>
                    <div class="row" style=" margin-top: 5px;">
                        <div class="col-md-3 col-lg-3">
                            <input type="text" name="captcha" id="captcha" value="" class="form-control"/>
                        </div>
                    </div>

                    <hr/>
                    <div class="row" style=" margin-top: 5px;">
                        <div class="col-md-3 col-lg-3">
                            <button type="button" class="btn btn-primary" onclick="Comment()">
                                ส่งข้อความ
                            </button>
                        </div>
                    </div>
                <?php } else { ?>
                    <div style=" text-align: center;">เข้าสู่ระบบเพื่อแสดงความคิดเห็น</div>
                <?php } ?>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <h4>อื่น ๆ</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="list-group">
                <?php foreach ($near->result() as $nears): ?>
                    <a href="<?php echo site_url('asbforum/post/view/' . $nears->id) ?>" class="list-group-item">
                        <span class="alert alert-success" style=" padding: 2px;">
                            <i class="fa fa-calendar"></i> <?php echo $model->thaidate($nears->create_date) ?></span> <?php echo $nears->title ?>
                        <span class="badge">ตอบ <?php echo $this->forum->CountComment($nears->id) ?></span>
                        <span class="badge">อ่าน <?php echo $nears->readpost ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- 
    #### Dialog Get Photo ###
-->
<!-- Modal -->
<div class="modal fade modal-wide " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="popupdialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">อัพโหลดรูปภาพ</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2 col-lg-2">
                        <form>
                            <div style="width:350px;">
                                <input id="file_upload" name="file_upload" type="file" multiple>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8 col-lg-8">
                        อัพโหลดได้ไม่เกินครั้งละ 1 MB | นามสกุลไฟล์ gif jpg png
                        <br />
                        <p style="color: #ff0000;">* หมายเหตุขนาดไฟล์อัพโหลดขึ้นอยู่กับการรับโหลดที่ server ด้วย</p>
                    </div>
                </div>
                <div id="img-uploads"></div>
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
            Repost();
        });
    }

    loadcomment();
    function loadcomment() {
        var url = "<?php echo site_url('asbforum/post/loadcomment') ?>";
        var comment_id = "<?php echo $commnetID ?>";
        var post_id = "<?php echo $post->id ?>";
        var data = {post_id: post_id,comment_id: comment_id};
        $.post(url, data, function (datas) {
            $("#data-comment").html(datas);
        });
    }

    function resetform() {
        Getcaptcha();
        CKEDITOR.instances.comment.setData(" ");
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
