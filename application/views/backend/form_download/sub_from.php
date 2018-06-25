<script type="text/javascript">
    function del_sub_from(sub_id, file) {
        $('#confrim').modal();
        $("#del_mas_menu").click(function () {
            var url = "<?= site_url('backend/form_download/delete_sub_from') ?>";
            var data = {sub_id: sub_id, file: file};

            $.post(url, data,
                    function (success) {
                        window.location.reload();
                    });// Endpost
        });
    }
</script>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#tb_mas_menu').dataTable({
            "bJQueryUI": false,
            //"sPaginationType" : "full_numbers",// แสดงตัวแบ่งหน้า
            "bLengthChange": false, // แสดงจำนวน record ที่จะแสดงในตาราง
            "iDisplayLength": 10, // กำหนดค่า default ของจำนวน record 
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
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#c_insert").click(function () {
            $("#Insert_menu").modal();
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        //####################### Insert Menu #########################
        $("#save_menu").click(function () {
            var url = "<?= site_url('backend/form_download/save_sub_from') ?>";
            var from_id = $("#from_id").val();
            var sub_name = $("#sub_name").val();
            var data = {from_id: from_id, sub_name: sub_name};

            if (sub_name == '') {
                $("#sub_name").focus();
                return false;
            }

            $.post(url, data, function (datas) {
                var sub_id = datas;
                window.location = "<?= site_url('backend/form_download/from_upload_file_sub_from/') ?>" + "/" + from_id + "/" + sub_id;
            });// Endpost
        });
    });
</script>


<?php
$this->load->library('takmoph_libraries');
$this->load->model('formdownload_model');
$model = new takmoph_libraries();
$formdowload_model = new formdownload_model();

$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
    array('url' => 'backend/form_download/get_mas_from', 'label' => 'แบบฟอร์ม')
);

$active = $head;
echo $model->breadcrumb_backend($list, $active);
?>

<h3><i class="fa fa-file-text-o"></i> <?= $head ?></h3>
<hr/>
<a href="#" id="c_insert"><div class="btn btn-default" style=" float:right;"><i class=" glyphicon glyphicon-plus"></i> เพิ่มเมนู</div></a>

<table width="100%" id="tb_mas_menu" class="table">
    <thead>
        <tr>
            <th>#</th>
            <th align="left">เรื่อง</th>
            <th align="left">ไฟล์</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($mas_from->result() as $rs):
            $type = substr($rs->file, -3);
            ?>
            <tr>
                <td><?= $i++ ?></td>
                <td align="left">
                    <?= $rs->sub_name ?> 
                </td>
                <td align="left">
                    <a href="<?php echo base_url() ?>file_download/<?= $rs->file ?>" target="_bank" style=" text-decoration: none;">
                        <?php echo $formdowload_model->get_type_file($type)?> <?= $rs->file ?></a>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-xs" onclick="del_sub_from('<?= $rs->sub_id ?>', '<?= $rs->file ?>');"><i class="fa fa-trash-o"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- 
#Delet
-->
<div id="confrim" class="modal fade">
    <div class=" modal-dialog">
        <div class=" modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">!แจ้งเตือน</h3>
            </div>
            <div class="modal-body"><img src="<?= base_url() ?>images/warning-icon.png"/> คุณต้องการลบเมนูนี้ ใช่ หรือ ไม่</div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                <button class="btn btn-primary" id="del_mas_menu">Ok</button>
            </div>
        </div>
    </div>
</div>

<!--
# update
-->
<div id="myModal" class="modal fade">
    <div class=" modal-dialog">
        <div class=" modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">แก้ไขเมนู</h3>
            </div>
            <div class="modal-body"><div id="load_edit_menu"></div></div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">ปิด</button>
                <button class="btn btn-primary" id="save_edit">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<!-- 
#Insert Menu 
-->
<div id="Insert_menu" class="modal fade">
    <div class=" modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">เพิ่มไฟล์</h3>
            </div>
            <div class="modal-body">
                <input type="hidden" id="from_id" class="form-control" value="<?= $from_id ?>"/>
                ชื่อแบบฟอร์ม : <br />
                <input type="text" id="sub_name" class="form-control"/>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">ปิด</button>
                <button class="btn btn-primary" id="save_menu">บันทึก</button>
            </div>
        </div>
    </div>
</div>

