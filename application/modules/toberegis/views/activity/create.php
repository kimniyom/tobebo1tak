<?php $path = base_url() . "assets/CK-Editor/"; ?>
<script src="<?= base_url() ?>assets/CK-Editor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //Modify By Kimniyom
        var windows = window.innerHeight;
        var contents = 300;
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
                //{name: 'insert', items: ['Image', 'Youtube']},
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
    array('url' => 'toberegis/activity/index', 'label' => 'รูปภาพกิจกรรม'),
);

$active = $head;
$eid = $this->takmoph_libraries->url_encode($this->session->userdata('tobe_user_id'));
echo $model->breadcrumb_backend($list, $active, 'toberegis/users/detailuser/' . $eid);
?>


<div style=" clear: both;">
    <h3><i class="fa fa-photo"></i> <?php echo $head ?></h3>
    <hr/>
</div>

<form id="from" name="from">
    <label>หัวข้อ / เรื่อง *</label>
    <input type="text" id="title" name="title" style="width:98%;" required="required" class="form-control input-mini"/>
    <label>รายละเอียด</label>
    <textarea id="detailnews" name="detailnews" class="form-control"></textarea> 
    <br/><br/>
    <label>ผู้เผยแพร่</label>
    <input type="text" id="user_" name="user_" style="width:98%;"  class="form-control input-mini"
           value="<?= $this->session->userdata('tobe_name') . '-' . $this->session->userdata('tobe_lname'); ?>" readonly="readonly"/>
    <hr/>
    <input type="button" class="btn btn-success" value="บันทึกข้อมูล" onclick="add_activity()"/>
    <input type="reset" class="btn btn-danger" value="ยกเลิก" />
</form>


<script type="text/javascript">
    function add_activity() {
        var detail = CKEDITOR.instances.detailnews.getData();
        var url = "<?php echo site_url('toberegis/activity/save') ?>";
        var title = $("#title").val();
        if (title == "") {
            alert("กรอก * ไม่ครบ ...?");
            return false;
        }
        var data = {
            title: title,
            detail: detail
        };
        $.post(url, data, function (datas) {
            window.location = "<?php echo site_url('toberegis/activity/view')  ?>" + "/" + datas.id;
        }, 'json');
    }
</script>


