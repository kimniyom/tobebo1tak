<?php $path = base_url() . "assets/CK-Editor/"; ?>
<script src="<?= base_url() ?>assets/CK-Editor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //Modify By Kimniyom
        CKEDITOR.replace('detail', {
            toolbar: [
                //{name: 'document', groups: ['mode', 'document', 'doctools'], items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']},
                //{name: 'clipboard', groups: ['clipboard', 'undo'], items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
                // {name: 'editing', groups: ['find', 'selection', 'spellchecker'], items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']},
                //{name: 'forms', items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField']},
                //'/',
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Underline', 'Strike', /*'Subscript', 'Superscript', '-', 'RemoveFormat'*/]},
                //{name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']},
                {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
                //{name: 'insert', items: [//'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']},
                //'/',
                {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
                {name: 'colors', items: ['TextColor', 'BGColor']},
                {name: 'tools', items: ['Maximize', 'ShowBlocks']},
                //{name: 'others', items: ['-']},
                //{name: 'about', items: ['About']}
            ],
            //filebrowserBrowseUrl: '<?//php echo $path; ?>ckfinder/ckfinder.html',
            //filebrowserImageBrowseUrl: '<?//php echo $path; ?>ckfinder/ckfinder.html?Type=Images',
            //filebrowserFlashBrowseUrl: '<?//php echo $path; ?>ckfinder/ckfinder.html?Type=Flash',
            //filebrowserUploadUrl: '<?//php echo $path; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            //filebrowserImageUploadUrl: '<?//php echo $path; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
            //filebrowserFlashUploadUrl: '<?//php echo $path; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        });

        $('#file_upload').uploadify({
            'buttonText': 'กรุณาเลือกไฟล์ ...',
            'auto': false, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('backend/pages/uploadfile/' . $pageid) ?>', //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
            'fileSizeLimit': '100MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
            //'width': '350',
            //'height': '40',
            'fileTypeExts': '*.zip; *.rar; *.ppt; *.pdf; *.doc;', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
            'multi': false, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
            'queueSizeLimit': 1, //อัพโหลดได้ครั้งละ 5 ไฟล์
            'onUploadComplete': function (success) { //เมื่ออัพโหลดเสร็จแล้วให้เรียกใช้งาน function load()
                window.location = "<?= site_url('backend/pages/view/' . $pageid . "/" . $admin_menu_id); ?>";
            }
        });
    });

    function Save() {
        var url = "<?php echo site_url('backend/pages/save') ?>";
        var title = $("#title").val();
        var group = $("#group").val();
        var admin_menu_id = $("#admin_menu_id").val();
        var detail = CKEDITOR.instances.detail.getData();
        if (title == '' || detail == '') {
            alert("กรอกข้อมูลไม่ครบ ...");
            return false;
        }
        var data = {
            
            title: title,
            detail: detail,
            group: group,
            admin_menu_id: admin_menu_id
        };
        $.post(url, data, function (datas) {
            $('#file_upload').uploadify('upload', '*');
            //window.location.reload();
            //var Id = datas.id;
            //var admin_menu_id = datas.admin_menu_id;
            //'takmoph_admin/from_upload_file_dengue/' . $row->id . '/' . $_POST['admin_menu_id']
            //window.location = "<?//php echo site_url() ?>/takmoph_admin/from_upload_file_dengue/" + Id + "/" + admin_menu_id;
        });
    }
</script>
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
        //array('url' => '', 'label' => 'menu2')
);

$active = $head;
echo $model->breadcrumb_backend($list, $active);
?>

<h3 style=" margin-bottom: 0px;"><img src="<?= base_url() ?>icon_menu/<?php echo $icon ?>" width="32"/> <?php echo $head ?></h3>
<hr/>
<a href="<?php echo site_url(array('backend/pages/create',$pageid,$admin_menu_id))?>">
    <button class="btn btn-default"><i class="fa fa-plus"></i> เพิ่มหัวข้อ</button></a>
<br/><br/>

        <table width="100%" class="table table-striped" id="danger">
            <thead>
                <tr style="height:40px;">
                    <th align="left" width="2%">#</th>
                    <th align="left">หัวข้อ</th>
                    <th>ผู้บันทึก</th>
                    <th style=" width: 20%;"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($dengue->result() as $rs):
                    ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td align="left">
                            <a href="<?php echo site_url('backend/pages/view/') . "/" . $rs->id . "/" . $rs->admin_menu_id ?>"><?= $rs->title ?></a>
                        </td>
                        <td><?php echo $rs->name." ".$rs->lname?></td>
                        <td style=" text-align: center;"><?php if($rs->d_update) echo $model->thaidate($rs->d_update); else echo "-"; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

<!--
    POPUP ADD ITEMS
-->
<div class="modal fade" tabindex="-1" role="dialog" id="popupcreate">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">เพิ่มหัวข้อ</h4>
            </div>
            <div class="modal-body">
                <label>หัวข้อ</label>
                <input type="text" id="title" name="title" required="required" class="form-control input-sm"/>
                <input type="hidden" id="group" name="group" value="<?php echo $head; ?>"/>
                <label>รายละเอียด</label>
                <textarea id="detail" rows="5" class="form-control"></textarea>
                <input type="hidden" id="admin_menu_id" name="admin_menu_id" value="<?php echo $admin_menu_id ?>"/>
                <label>แนบไฟล์ *.zip; *.rar; *.ppt; *.pdf; *.doc</label>
                <input id="file_upload" name="file_upload" type="file" multiple>
                <label>ผู้เผยแพร่</label>
                <input type="text" id="user_" name="user_" class="form-control input-sm"
                       value="<?php echo $this->session->userdata('name') . '-' . $this->session->userdata('lname'); ?>" readonly="readonly"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="Save()"><i class="fa fa-save"></i> บันทึกข้อมูล</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#tb_mas_menu,#danger').dataTable({
            "bJQueryUI": false,
            //"sPaginationType" : "full_numbers",// แสดงตัวแบ่งหน้า
            "bLengthChange": false, // แสดงจำนวน record ที่จะแสดงในตาราง
            "iDisplayLength": 15, // กำหนดค่า default ของจำนวน record 
            //"sScrollY": "100px",
            "bFilter": false, // แสดง search box
            "oLanguage": {
                "sLengthMenu": "แสดง _MENU_ เร็คคอร์ด ต่อหน้า",
                "sZeroRecords": "ไม่เจอข้อมูลที่ค้นหา",
                "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ เร็คคอร์ด",
                "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 เร็คคอร์ด",
                "sInfoFiltered": "(จากเร็คคอร์ดทั้งหมด _MAX_ เร็คคอร์ด)",
                "sSearch": "ค้นหา :",
                "oPaginate": {
                    "sFirst": "หน้าแรก",
                    "sLast": "หน้าสุดท้าย",
                    "sNext": "ถัดไป",
                    "sPrevious": "กลับ"
                }
            }
        });
    });

    function delete_danger(id, admin_menu) {
        var r = confirm("คุณต้องการลบข้อมูลนี้ ใช่ หรือ ไม่ ...");
        if (r == true) {
            var url = "<?php echo site_url('backend/pages/delete') ?>";
            var data = {id: id, admin_menu: admin_menu};
            $.post(url, data, function (success) {
                window.location.reload();
            });
        }
    }

    function additem() {
        $("#popupcreate").modal();
    }
</script>

