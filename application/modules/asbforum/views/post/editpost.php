<style type="text/css">
    .row{
        margin-top: 10px;
    }
    .modal.modal-wide .modal-dialog {
        width: 95%;
    }
    .modal-wide .modal-body {
        overflow-y: auto;
    }
</style>
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = "";
$active = $head;
?>
<?php echo $model->breadcrumb_backend($list, $active, "asbforum"); ?>
<script src="<?= base_url() ?>assets/CK-Editor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        CKEDITOR.replace('detail', {
            language: 'th',
            //height: 500,
            //uiColor: '#FFFFFF',
            //{ name: 'document', items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
            removePlugins: 'bidi,forms,flash,iframe,div,find',
            removeButtons: 'Anchor,Underline,Strike,Subscript,Superscript,Editing,Templates,Preview,NewPage,Source,Save,Scayt,About,Print,Cut,Language'
        });
    });
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

<h3 id="head_submenu">
    <i class="fa fa-file-text-o fa-2x text-warning"></i>
    <?php echo $head; ?>
</h3>

<hr id="hr"/>

<div class="row">
    <div class="col-lg-3" style=" text-align: right;">
        <label>หมวด</label>
    </div>
    <div class="col-md-4 col-lg-4">
        <select id="category" class="form-control select-box" onchange="ChageSubcategory(this.value)">
            <?php foreach ($category->result() as $cat): ?>
                <option value="<?php echo $cat->id ?>" <?php if ($cat->id == $activecategory) echo "selected"; ?>><?php echo $cat->title ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div id="box-subcategory">

</div>

<div class="row">
    <div class="col-lg-3" style=" text-align: right;">
        <label>หัวข้อ</label>
    </div>
    <div class="col-md-9 col-lg-9">
        <input type="text" class="form-control" id="title" value="<?php echo $post->title ?>"/>
    </div>
</div>
<div class="row">
    <div class="col-lg-3" style=" text-align: right;">
        <label>รายละเอียด</label>
    </div>
    <div class="col-md-9 col-lg-9">
        <textarea class="form-control text-area" id="detail" rows="5"><?php echo $post->detail ?></textarea>
    </div>
</div>

<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-md-3 col-lg-3">
        <button type="button" class="btn btn-default" onclick="openuploads()">
            <i class="fa fa-photo"></i> แทรกรูปภาพ
        </button>
    </div>
    <div class="col-md-3 col-lg-3" style=" padding-top: 10px;">
        <input type="radio" name="privilege" id="privilege" value="0" <?php
        if ($post->privilege == "0") {
            echo "checked";
        }
        ?>/> ทุกคนมองเห็น
        <input type="radio" name="privilege" id="privilege" value="1" <?php
        if ($post->privilege == "1") {
            echo "checked";
        }
        ?>/> เฉพาะสมาชิก
    </div>
</div>

<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-md-9 col-lg-9">
        <label>พิมพ์ตัวอักษรที่เห็นในรูปด้านล่าง</label>
    </div>
</div>
<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-md-2 col-lg-2">
        <div id="getcaptcha"></div>
    </div>
    <div class="col-md-2 col-lg-2" style="padding-top: 15px;">
        <a href="javascript:Getcaptcha()"><i class="fa fa-refresh"></i></a></button>
    </div>
</div>
<div class="row" style=" margin-top: 5px;">
    <div class="col-lg-3" id="t"></div>
    <div class="col-md-3 col-lg-3">
        <input type="text" name="captcha" id="captcha" value="" class="form-control"/>
    </div>
</div>

<hr/>
<div class="row" style=" margin-top: 5px;">
    <div class="col-lg-3"></div>
    <div class="col-md-3 col-lg-3">
        <button type="button" class="btn btn-primary" onclick="EditPost()">
            แก้ไขกระทู้
        </button>
    </div>
</div>

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

    function Addcontent(img) {
        var url = "<?php echo base_url() ?>assets/module/asbforum/albumphoto" + "/" + img;
        var res = img.replace(".", "");
        var content = "<img src='" + url + "' style='width:500px;' id='img-post" + res + "'/>";

        var detail = CKEDITOR.instances.detail.getData();
        CKEDITOR.instances.detail.setData(detail + content);
        $("#popupdialog").modal('hide');
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        ChageSubcategory("<?php echo $activecategory ?>");
    });

    function ChageSubcategory(catid) {
        var url = "<?php echo site_url('asbforum/post/getsubcategoryactive') ?>";
        var subcat_id = "<?php echo $activesubcategory ?>";
        var data = {catid: catid, subcat_id: subcat_id};
        $.post(url, data, function (datas) {
            $("#box-subcategory").html(datas);
        });
    }

    function loadimages() {
        var url = "<?php echo site_url('asbforum/albumphoto/getalbum') ?>";
        var data = {};
        $.post(url, data, function (datas) {
            $("#img-uploads").html(datas);
        });
    }

    function EditPost() {
        var post_id = "<?php echo $post->id ?>";
        var url = "<?php echo site_url('asbforum/post/saveupdate') ?>";
        var category = $("#category").val();
        var subcategory = $("#sub_cat").val();
        var title = $("#title").val();
        var detail = CKEDITOR.instances.detail.getData();
        var captcha = $("#captcha").val();
        var recaptcha = $("#recaptcha").val();
        var privilege = $("#privilege").is(':checked') ? 0 : 1;

        if (captcha != recaptcha) {
            alert("กรอกรหัสภาพไม่ถูกต้อง");
            return false;
        }

        if (category == "") {
            $("#category").focus();
            return false;
        }

        if (title == "") {
            $("#title").focus();
            return false;
        }

        if (detail == "") {
            $("#detail").focus();
            return false;
        }

        var data = {
            title: title,
            category: category,
            subcategory: subcategory,
            detail: detail,
            privilege: privilege,
            post_id: post_id
        };

        $.post(url, data, function (datas) {
            var urlredir = "<?php echo site_url('asbforum/users/viewpost') ?>" + "/" + post_id;
            window.location = urlredir;
        });

    }
</script>


