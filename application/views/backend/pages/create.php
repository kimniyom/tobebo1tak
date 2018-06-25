<?php $path = base_url() . "assets/CK-Editor/"; ?>
<script src="<?= base_url() ?>assets/CK-Editor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        //Modify By Kimniyom
        CKEDITOR.replace('detail', {
            language: 'th',
            toolbar: [
                //{name: 'document', groups: ['mode', 'document', 'doctools'], items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']},
                //{name: 'clipboard', groups: ['clipboard', 'undo'], items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
                // {name: 'editing', groups: ['find', 'selection', 'spellchecker'], items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']},
                //{name: 'forms', items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField']},
                //'/',
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Underline', 'Strike', /*'Subscript', 'Superscript', '-', 'RemoveFormat'*/]},
                //{name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']},
                {name: 'links', items: ['Link']}, //, 'Unlink', 'Anchor'
                //{name: 'insert', items: [//'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']},
                //'/',
                {name: 'insert', items: ['Image']},
                {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
                {name: 'colors', items: ['TextColor', 'BGColor']},
                {name: 'tools', items: ['Maximize', 'ShowBlocks']},
                        //{name: 'others', items: ['-']},
                        //{name: 'about', items: ['About']}
            ],
        });

        $('#file_upload').uploadify({
            'buttonText': 'กรุณาเลือกไฟล์ ...',
            'auto': false, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('backend/pages/uploadfile/' . $id) ?>', //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
            'fileSizeLimit': '10MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
            //'width': '350',
            //'height': '40',
            'fileTypeExts': '*.zip; *.rar; *.ppt; *.pdf; *.doc;', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
            'multi': false, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
            'queueSizeLimit': 1, //อัพโหลดได้ครั้งละ 5 ไฟล์
            'onSelect': function (file) {
                //alert('The file ' + file.name + ' was added to the queue.');
                $("#filedata").val(file.name);
            },
            'onCancel': function (file) {
                $("#filedata").val("");
            },
            'onUploadComplete': function (success) { //เมื่ออัพโหลดเสร็จแล้วให้เรียกใช้งาน function load()
                window.location = "<?= site_url('backend/pages/view/' . $id . "/" . $admin_menu_id); ?>";
            }
        });
    });

</script>
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
    array('url' => 'backend/pages/getpage/' . $admin_menu_id, 'label' => $group),
);

$active = $head;
echo $model->breadcrumb_backend($list, $active);
?>
<br/>
<hr/>

<input type="hidden" id="filedata"/>

<div class="well well-sm">
    <label>หัวข้อ</label>
    <input type="text" id="title" name="title" required="required" class="form-control input-sm"/>
    <input type="hidden" id="group" name="group" value="<?php echo $head; ?>"/>
    <label>รายละเอียด</label>
    <textarea id="detail" rows="5" class="form-control"></textarea>
    <button type="button" class="btn btn-default" onclick="getstoreimages('0')"><i class="fa fa-image"></i> แทรกรูปภาพในเนื้อหา</button>
    <button type="button" class="btn btn-default" onclick="getstoreimages('1')"><i class="fa fa-link"></i> แทรกไฟล์ในเนื้อหา</button>
    <input type="hidden" id="admin_menu_id" name="admin_menu_id" value="<?php echo $admin_menu_id ?>"/>

    <!--
    <label>แนบไฟล์ *.zip; *.rar; *.ppt; *.pdf; *.doc</label>
    <input id="file_upload" name="file_upload" type="file" multiple>
    -->
    <br/><br/>
    <label>ผู้เผยแพร่</label>
    <input type="text" id="user_" name="user_" class="form-control input-sm"
           value="<?php echo $this->session->userdata('name') . '-' . $this->session->userdata('lname'); ?>" readonly="readonly"/>
    <br/>
    <button type="button" class="btn btn-success" onclick="Save()"><i class="fa fa-save"></i> บันทึกข้อมูล</button>
</div>

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
    
    function Save() {
        var url = "<?php echo site_url('backend/pages/save') ?>";
        var id = "<?php echo $id ?>";
        var title = $("#title").val();
        var group = $("#group").val();
        var admin_menu_id = $("#admin_menu_id").val();
        var detail = CKEDITOR.instances.detail.getData();

        if (title == '' || detail == '') {
            alert("กรอกข้อมูลไม่ครบ ...");
            return false;
        }
        var data = {
            id: id,
            title: title,
            detail: detail,
            group: group,
            admin_menu_id: admin_menu_id
        };
        $.post(url, data, function (datas) {
            window.location = "<?= site_url('backend/pages/view/' . $id . "/" . $admin_menu_id); ?>";
            /*
             if ($("#filedata").val() != '') {
             $('#file_upload').uploadify('upload', '*');
             } else {
             window.location = "<?php //echo site_url('backend/pages/view/' . $id . "/" . $admin_menu_id);  ?>";
             }
             */
        });
    }

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
        var url = "<?php echo site_url('backend/storeimg/index') ?>" + "/" + type;
        $("#store-img").load(url);
        $("#popupstoreimages").modal();
    }

    function reloadstoreimg(type) {
        getstoreimages(type);
    }
    function Addcontent(folder, img, name, type) {

        var url = "<?php echo base_url() ?>upload_images/" + folder + "/" + img;
        var res = img.replace(".", "");
        var content;
        if (type == "0") {
            content = "<img src='" + url + "' style='width:500px;' id='img-post" + res + "'/>";
        } else {
            content = "<a href='" + url + "' id='img-post" + res + "' target='_blank'><b>" + name + "</b></a>";
        }

        var detail = CKEDITOR.instances.detail.getData();
        CKEDITOR.instances.detail.setData(detail + content);
        closeAll();
    }
</script>