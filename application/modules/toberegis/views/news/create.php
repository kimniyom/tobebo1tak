<?php $path = base_url() . "assets/CK-Editor/"; ?>
<script src="<?= base_url() ?>assets/CK-Editor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //Modify By Kimniyom
        var windows = window.innerHeight;
        var contents = windows - 450;
        CKEDITOR.replace('detailnews', {
            height: contents,
            toolbar: [
                //{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                {name: 'clipboard', groups: ['clipboard', 'undo'], items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
                //{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                //{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                '/',
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']},
                {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl']},
                {name: 'links', items: ['Link']}, //, 'Unlink', 'Anchor'
                //{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                {name: 'insert', items: ['Image', 'Youtube']},
                '/',
                {name: 'styles', items: ['Styles', 'Format', 'FontSize']}, /*Font*/
                {name: 'colors', items: ['TextColor', 'BGColor']},
                {name: 'tools', items: ['Maximize', 'ShowBlocks']}
                //{ name: 'others', items: [ '-' ] },
                //{ name: 'about', items: [ 'About' ] }
            ],
            language: 'th',
            uiColor: '#eeeeee'
                    /*
                     filebrowserBrowseUrl: '<?php //echo $path;                           ?>ckfinder/ckfinder.html',
                     filebrowserImageBrowseUrl: '<?php //echo $path;                           ?>ckfinder/ckfinder.html?Type=Images',
                     //filebrowserFlashBrowseUrl: '<?//php echo $path; ?>ckfinder/ckfinder.html?Type=Flash',
                     filebrowserUploadUrl: '<?php //echo $path;                           ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                     filebrowserImageUploadUrl: '<?php //echo $path;                           ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
                     */
        });
    });
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


<div style=" clear: both;">
    <h3><i class="fa fa-newspaper-o"></i> <?php echo $head ?></h3>
    <hr/>
</div>

<form id="from" name="from">
    <label>หัวข้อ</label>
    <input type="text" id="title" name="title" style="width:98%;" required="required" class="form-control input-mini"/>
    <label>รายละเอียด</label>
    <textarea id="detailnews" name="detailnews" class="form-control"></textarea> 
    <br/>
    <button type="button" class="btn btn-default" onclick="getstoreimages('0')"><i class="fa fa-image"></i> แทรกรูปภาพในเนื้อหา</button>
    <button type="button" class="btn btn-default" onclick="getstoreimages('1')"><i class="fa fa-link"></i> แทรกไฟล์ในเนื้อหา</button>
    <br/><br/>
    <label>ผู้เผยแพร่</label>
    <input type="text" id="user_" name="user_" style="width:98%;"  class="form-control input-mini"
           value="<?= $this->session->userdata('tobe_name') . '-' . $this->session->userdata('tobe_lname'); ?>" readonly="readonly"/>
    <hr/>
    <input type="button" class="btn btn-success" value="บันทึกข้อมูล" onclick="add_new()"/>
    <input type="reset" class="btn btn-danger" value="ยกเลิก" />
</form>

<!-- 
    Add Edit Delete 
-->

<div class="modal fade" id="popupstoreimages" data-backdrop="static">
    <div class="modal-dialog" style=" width: 100%; margin: 5px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class=" pull-right" onclick="closeAll()"><span>&times;</span></button>
                <h4 id="myModalLabel"></h4>
            </div>
            <div class="modal-body" id="b-img" style=" overflow: auto; position: relative;"> 
                <div id="store-img"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function closeAll() {
        $('#popupstoreimages').modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    }

    function getstoreimages(type) {
        if (type == "0") {
            $("#myModalLabel").text("รูปภาพ");
        } else {
            $("#myModalLabel").text("ไฟล์");
        }
        var url = "<?php echo site_url('toberegis/storeimg/index') ?>" + "/" + type;
        $("#store-img").load(url);
        $("#popupstoreimages").modal();
    }

    function reloadstoreimg(type) {
        getstoreimages(type);
    }

    function add_new() {
        var detail = CKEDITOR.instances.detailnews.getData();
        var url = "<?php echo site_url('toberegis/news/save_news') ?>";
        if (detail == "") {
            alert("กรอกรายละเอียด ...?");
            return false;
        }
        var data = {
            title: $("#title").val(),
            detail: detail
        };
        $.post(url, data, function (datas) {
            window.location = "<?php echo site_url('toberegis/news/view')  ?>" + "/" + datas.id;
        }, 'json');
    }

    function Addcontent(folder, img, name, type) {
        var url = "<?php echo base_url() ?>upload_images/" + folder + "/" + img;
        var res = img.replace(".", "");
        var content;
        if (type == "0") {
            content = "<a href='" + url + "' class='fancybox'>" + "<img src='" + url + "' style='width:500px;' id='img-post" + res + "'/></a>";
            //content = "<img src='" + url + "' style='width:500px;' id='img-post" + res + "'/>";
        } else {
            content = "<a href='" + url + "' id='img-post" + res + "' target='_blank'><b>" + name + "</b></a>";
        }

        var detailnews = CKEDITOR.instances.detailnews.getData();
        CKEDITOR.instances.detailnews.setData(detailnews + content);
        closeAll();
    }
</script>


