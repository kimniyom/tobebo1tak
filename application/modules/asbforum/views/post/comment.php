<style type="text/css">
    .modal.modal-wide .modal-dialog {
        width: 95%;
    }
    .modal-wide .modal-body {
        overflow-y: auto;
    }
</style>
<script type="text/javascript">

    function ascrollto(commentID) {

        if (commentID != null) {
            var etop = $('#comment' + commentID).offset().top;
            $('html, body').animate({
                scrollTop: etop
            }, 1000);
        }
    }
    function SetImgResponsive(BoxID) {
        var BoxComment = BoxID;
        var tn_array = $(BoxComment + ' img').map(function () {
            return $(this).attr("id");
        });

        for (var i = 0; i < tn_array.length; i++) {
            var tagimg = tn_array[i];
            var widthimg = $(BoxComment).width();
            var img = $(BoxComment + " #" + tagimg).width();
            if (img >= widthimg) {
                $(BoxComment + " #" + tagimg).addClass("img-responsive");
                $(BoxComment + " #" + tagimg).css({"width": "auto", "height": "auto"});
            }
        }

    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        //loaddata();
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
                loadimagesrecomment();
            }
        });
    });
</script>
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
?>

<?php
$i = 0;
foreach ($comment->result() as $comments): $i++;
    echo "<script type='text/javascript'>SetImgResponsive('.ans-comment" . $i . "')</script>";
    if ($comments->user_post == $comments->user_id) {
        $bg = "background:#FFFFFF;";
    } else {
        $bg = "background:none;";
    }
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            CKEDITOR.replace('detailrecomment<?php echo $i ?>', {
                language: 'th',
                //height: 500,
                uiColor: '#999999',
                //{ name: 'document', items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
                removePlugins: 'bidi,forms,flash,iframe,div,find',
                removeButtons: 'Maximize,Anchor,Underline,Strike,Subscript,Superscript,Editing,Templates,Preview,NewPage,Source,Save,Scayt,About,Print,Cut,Language,Copy,Paste,SelectAll,PasteFromWord,Undo,Redo,PasteText,Table,CopyFormatting,HorizontalRule,PageBreak,SpecialChar,RemoveFormat,ShowBlocks'
            });
        });
    </script>
    <div id="comment<?php echo $comments->id ?>" style=" border: #cccccc solid 1px; padding: 10px; margin-bottom: 5px; <?php echo $bg ?>">
        <div class="row">
            <div class="col-md-2 col-lg-2" style=" font-size: 12px;">
                <div style=" text-align: center;">
                    <?php if ($comments->photo != "") { ?>
                        <img src="<?php echo base_url() ?>assets/module/asbforum/uploads/<?php echo $comments->photo ?>" class="img img-responsive" style=" width: 100px;"/>
                    <?php } else { ?>
                        <img src="<?php echo base_url() ?>assets/module/asbforum/images/profile-icon.png" class="img img-responsive" style=" width: 100px;"/>
                    <?php } ?>
                    ความคิดเห็นที่ <?php echo $i ?>
                </div>

            </div>
            <div class="col-md-10 col-lg-10">
                <div class="well well-sm" style=" background: #ffffff;">
                    <div class="ans-comment<?php echo $i ?>">
                        <?php echo $comments->comment; ?>
                    </div>
                    <hr/>
                    #<?php echo $comments->id; ?> | โดย  : <?php echo $comments->alias ?> | 
                    วันที่ : <?php echo $model->thaidate($comments->create_date) ?> | 
                    IP : <?php echo $comments->ip ?>
                    <!--
                    <button type="button" class="btn btn-default btn-xs" data-toggle="collapse" data-target="#recomment<?php //echo $i  ?>"><i class="fa fa-reply"></i> ตอบกลับ</button>
                    -->
                    <?php if ($this->session->userdata('forum_user_id') == $comments->user_id) { ?>
                        <a href="javascript:deletecomment('<?php echo $comments->id ?>')" class="pull-right"><i class="fa fa-trash-o"></i></a> 
                    <?php } else { ?>
                        <a href="javascript:deleteflag('<?php echo $comments->id ?>')" class="pull-right text-danger">แจ้งลบ</a>
                    <?php } ?>
                    <?php $detailcomment = "detailrecomment" . $i; ?>


                    <div id="boxrecomment<?php echo $i ?>"></div>

                    <div id="recomment<?php echo $i ?>" class="collapse">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <textarea class="form-control text-area" name="<?php echo $detailcomment ?>" id="<?php echo $detailcomment ?>" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="row" style=" margin-top: 10px;">
                            <div class="col-md-3 col-lg-3"><button type="button" class="btn btn-default btn-block btn-sm" onclick="openuploadsrecomment('<?php echo $detailcomment ?>')"><i class="fa fa-photo"></i> แทรกรูปภาพ</button></div>
                            <div class="col-md-3 col-lg-3"><button type="button" class="btn btn-success btn-sm" onclick="Saverecomment('<?php echo $detailcomment ?>', '<?php echo $comments->id ?>', '<?php echo $i ?>')"><i class="fa fa-reply"></i> ส่งข้อความ</button></div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

<?php endforeach; ?>

<!-- Modal -->
<div class="modal fade modal-wide " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="popupdialogrecomment" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">อัพโหลดรูปภาพ</h4>
            </div>
            <div class="modal-body">
                <input type="text" id="setrecomment"/>
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
                <div id="img-uploads-recomment"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    ascrollto(<?php echo $commentActive ?>);
    function deletecomment(id) {
        var url = "<?php echo site_url('asbforum/post/deletecomment') ?>";
        var data = {id: id};
        $.post(url, data, function (datas) {
            loadcomment();
            Repost();
        });
    }

    function deleteflag(id) {
        var url = "<?php echo site_url('asbforum/post/deletecommentflag') ?>";
        var data = {id: id};
        $.post(url, data, function (datas) {
            $.notify({
                // options
                message: 'ระบบได้รับการแจ้งลบของท่านแล้ว'
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

    function openuploadsrecomment(recomment_id) {
        $("#setrecomment").val(recomment_id);
        loadimagesrecomment();
        $("#popupdialogrecomment").modal();
    }

    function loadimagesrecomment() {
        var url = "<?php echo site_url('asbforum/albumphoto/Getalbumrecomment') ?>";
        var data = {};
        $.post(url, data, function (datas) {
            $("#img-uploads-recomment").html(datas);
        });
    }

    function Addcontentrecomment(img) {
        var url = "<?php echo base_url() ?>assets/module/asbforum/albumphoto" + "/" + img;
        var res = img.replace(".", "");
        var content = "<img src='" + url + "' style='width:500px;' id='img-comment" + res + "'/>";
        var detailcomment = $("#setrecomment").val();
        var detail = CKEDITOR.instances[detailcomment].getData();
        CKEDITOR.instances[detailcomment].setData(detail + content);
        $("#popupdialogrecomment").modal('hide');
    }


    function resetformrecomment(detailcomment) {
        CKEDITOR.instances[detailcomment].setData("");
    }

    function Saverecomment(recomment_id, comment_id, id) {
        $("#setrecomment").val(recomment_id);
        var url = "<?php echo site_url('asbforum/post/forumrecomment') ?>";
        var post_id = "<?php echo $post_id ?>";
        var detailcomment = $("#setrecomment").val();
        var comment = CKEDITOR.instances[detailcomment].getData();
        if (comment == "") {
            $("#" + detailcomment).focus();
            return false;
        }


        var data = {post_id: post_id, comment: comment, comment_id: comment_id};

        $.post(url, data, function (datas) {
            resetformrecomment(detailcomment);
            Recomment();
            Getrecomment(id, comment_id);
        });
    }

    function Getrecomment(id, comment_id) {
        var url = "<?php echo site_url('asbforum/post/getrecomment') ?>";
        var data = {comment_id: comment_id, id: id};
        $.post(url, data, function (datas) {
            alert(id + datas);
            $("#boxrecomment" + id).html(datas);
        });
    }
</script>


