<?php $path = base_url() . "assets/CK-Editor/"; ?>
<script src="<?= base_url() ?>assets/CK-Editor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //Modify By Kimniyom
        var windows = window.innerHeight;
        var contents = windows - 350;
        CKEDITOR.replace('_detail', {
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
                     filebrowserBrowseUrl: '<?php //echo $path;                        ?>ckfinder/ckfinder.html',
                     filebrowserImageBrowseUrl: '<?php //echo $path;                        ?>ckfinder/ckfinder.html?Type=Images',
                     //filebrowserFlashBrowseUrl: '<?//php echo $path; ?>ckfinder/ckfinder.html?Type=Flash',
                     filebrowserUploadUrl: '<?php //echo $path;                        ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                     filebrowserImageUploadUrl: '<?php //echo $path;                        ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
                     */
        });
    });
</script>


<?php
$this->load->library('takmoph_libraries');

$model = new takmoph_libraries();
$eid = $this->takmoph_libraries->url_encode($this->session->userdata('tobe_user_id'));
$list = array(
    array('url' => 'toberegis/news/index', 'label' => 'ข่าวประชาสัมพันธ์'),
    array('url' => 'toberegis/news/view/'.$this->takmoph_libraries->url_encode($news->id), 'label' => $news->id),
);
$active = "แก้ไข";

echo $model->breadcrumb_backend($list, $active, 'toberegis/users/detailuser/' . $eid);
?>
<!-- Dialog Insert News -->
<div style=" clear: both;">
<h3><i class="fa fa-pencil"></i> แก้ไข</h3>
<hr/>
</div>

<form id="from" name="from">
    <input type="hidden"  id="_new_id" name="_new_id" value="<?= $news->id; ?>"/>
    <label>หัวข้อ</label>
    <input type="text" id="_title" name="_title" style="width:98%;" required="required" value="<?php echo $news->title ?>" class="form-control input-mini"/>
    <label>รายละเอียด</label>
    <textarea id="_detail" name="_detail" class="form-control"><?php echo $news->detail ?></textarea> 
    <br/>
    <button type="button" class="btn btn-default" onclick="getstoreimages('0')"><i class="fa fa-image"></i> แทรกรูปภาพในเนื้อหา</button>
    <button type="button" class="btn btn-default" onclick="getstoreimages('1')"><i class="fa fa-link"></i> ไฟล์ในเนื้อหา</button>

    <br/><br/>
    <label>ผู้เผยแพร่</label>
    <input type="text" id="user_" name="user_" style="width:98%;"  class="form-control input-mini"
           value="<?= $this->session->userdata('tobe_name') . '-' . $this->session->userdata('tobe_lname'); ?>" readonly="readonly"/>
    <hr/>
    <input type="button" class="btn btn-success" value="บันทึกข้อมูล" onclick="edit_news()"/>
    <input type="reset" class="btn btn-danger" value="ยกเลิก" />
</form>

<!-- 
    Add Edit Delete 
-->

<div id="popupstoreimages" class="modal fade  bs-example-modal-lg" data-backdrop="static">
    <div class="modal-dialog modal-lg" style=" width: 100%; margin: 5px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class=" pull-right" onclick="closeAll()"><span>&times;</span></button>
                <h4 id="myModalLabel">รูปภาพ</h4>
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

    function reloadstoreimg() {
        getstoreimages();
    }

    function edit_news() {
        //var _detail = $("#_detail").Editor("getText");
        var _detail = CKEDITOR.instances._detail.getData();

        if (_detail == "") {
            alert("กรอกรายละเอียด ...?");
            return false;
        }
        var data = {
            _new_id: $("#_new_id").val(),
            _title: $("#_title").val(),
            _detail: _detail
        };

        $.ajax({
            type: "POST",
            url: "<?= site_url('toberegis/news/edit_news') ?>",
            data: data,
            success: function () {
                window.location = "<?php echo site_url('toberegis/news/view/' . $this->takmoph_libraries->url_encode($news->id)) ?>";
            }
        });
    }

    function Addcontent(folder, img, name, type) {
        var url = "<?php echo base_url() ?>upload_images/" + folder + "/" + img;
        var res = img.replace(".", "");
        var content;
        if (type == "0") {
            content = "<a href='" + url + "' class='fancybox'>" + "<img src='" + url + "' style='width:500px;' id='img-post" + res + "'/></a>";
        } else {
            content = "<a href='" + url + "' id='img-post" + res + "' target='_blank'><b>" + name + "</b></a>";
        }

        var detailnews = CKEDITOR.instances._detail.getData();
        CKEDITOR.instances._detail.setData(detailnews + content);
        closeAll();
    }
</script>


