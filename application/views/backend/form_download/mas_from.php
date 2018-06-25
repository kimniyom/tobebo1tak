<style type="text/css">
    .t_box{ width:97%;}
</style>
<script type="text/javascript">
    function edit_mas_form(mas_id) {
        var url = "<?= site_url('backend/form_download/edit_mas_form') ?>";
        var data = {id: mas_id};

        $.post(url, data,
                function (success) {
                    $("#form_edit").html(success);
                    $('#Edit_mas_form').modal();
                });// Endpost
    }

</script>

<script type="text/javascript">
    function del_mas_from(from_id, file) {

        $('#confrim').modal();

        $("#del_mas_menu").click(function () {
            var url = "<?= site_url('backend/form_download/delete_mas_from') ?>";
            var data = {from_id: from_id, file: file};

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
    // ####################### Insert Menu #########################-
    function save_mas_menu() {
        var url = "<?= site_url('backend/form_download/save_from') ?>";
        var mas_from = $("#mas_from").val();
        var from_status = $("#from_status").val();
        var data = {mas_from: mas_from, from_status: from_status};
        if(mas_from == ''){
            $("#mas_from").focus();
            return false;
        }
        
        if(from_status == ''){
            $("#from_status").focus();
            return false;
        }
        
        $.post(url, data,
                function (datas) {
                    var id = datas.id;
                    if (datas.type == 0) {
                        window.location = "<?= site_url('backend/form_download/from_upload_file_from/') ?>" + "/" + id;
                    } else {
                        window.location = "<?php echo site_url('backend/form_download/get_sub_from/') ?>" + "/" + id;
                    }
                }, "Json");// Endpost
    }
</script>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
        //array('url' => 'backend/news/get_news', 'label' => 'ข่าว')
);

$active = $head;
echo $model->breadcrumb_backend($list, $active);
?>

<h3><i class="fa fa-file-text-o"></i> <?= $head ?></h3>
<hr/>
<a href="javascript:void(0);" id="c_insert">
    <div class="btn btn-success" style=" float:right;">
        <i class=" glyphicon glyphicon-plus"></i> เพิ่มแบบฟอร์ม
    </div>
</a>
<table width="100%" id="tb_mas_menu" class="table">
    <thead>
        <tr>
            <th>#</th>
            <th align="left">เรื่อง</th>
            <th align="left">ไฟล์/ลิงค์</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($mas_from->result() as $rs):
            ?>
            <tr>
                <td><?= $i++ ?></td>
                <td align="left">
                    <?php if ($rs->from_status == '1') { ?> 
                        <a href="<?= site_url('backend/form_download/get_sub_from/' . $rs->id . '/' . $rs->mas_from); ?>"><?= $rs->mas_from ?></a> 
                    <?php } else { ?> 
                        <?= $rs->mas_from ?>
                    <?php } ?>
                </td>
                <td align="left">
                    <?php
                    if ($rs->from_status == '1') {
                        echo "Link";
                    } else {
                        echo $rs->file;
                    }
                    ?></td>
                <td>
                    <div class="btn-group pull-right" style=" text-align:left;">
                        <a class="btn dropdown-toggle btn-default btn-xs" data-toggle="dropdown" href="#">
                            จัดการ <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#" onclick="edit_mas_form('<?= $rs->id ?>');"><i class=" glyphicon glyphicon-pencil"></i> แก้ไข</a></li>
                            <li><a href="#" onclick="del_mas_from('<?= $rs->id ?>', '<?= $rs->file ?>');"><i class=" glyphicon glyphicon-trash"></i> ลบ</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Maneger -->

<div id="confrim" class="modal fade">
    <div class="modal-dialog">
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
# แก้ไข
-->
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">แก้ไขเมนู</h3>
            </div>
            <div class="modal-body"><div id="load_edit_menu"></div></div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">ปิด</button>
                <button class="btn btn-primary" id="save_edit">แก้ไข</button>
            </div>
        </div>
    </div>
</div>

<!-- 
#Insert Menu 
-->
<div id="Insert_menu" class="modal fade">
    <div class="modal-dialog">
        <div class=" modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">เพิ่มแบบฟอร์ม</h3>
            </div>
            <div class="modal-body">
                ชื่อ : <br />
                <input type="text" id="mas_from" class="form-control"/>
                ประเภท : <br />
                <select  id="from_status" class="form-control">
                    <option value="">== กรุณาเลือก ==</option>
                    <option value="1">มีเมนูย่อย</option>
                    <option value="0">ไม่มีเมนูย่อย</option>
                </select><br />
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">ปิด</button>
                <button class="btn btn-primary" onclick="save_mas_menu()">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit -- >
<!-- 
#Insert Menu 
-->
<div id="Edit_mas_form" class="modal fade">
    <div class="modal-dialog">
        <div class=" modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">แก้ไขเรื่อง</h3>
            </div>
            <div class="modal-body" id="form_edit">

            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">ปิด</button>
                <button class="btn btn-primary" onclick="save_edit_mas_form()">บันทึก</button>
            </div>
        </div>
    </div>
</div>
