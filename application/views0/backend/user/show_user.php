<script type="text/javascript">
    $(document).ready(function () {
        $("#add_new").click(function () {
            $("#box-add-user").modal();
        });
    });
</script>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#tb_mas_menu').dataTable({
            "bJQueryUI": false,
            //"sPaginationType" : "full_numbers",// แสดงตัวแบ่งหน้า
            "bLengthChange": false, // แสดงจำนวน record ที่จะแสดงในตาราง
            "iDisplayLength": 20, // กำหนดค่า default ของจำนวน record 
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

<br/>
<!-- Dialog Insert News -->

<h3><i class="fa fa-newspaper-o"></i> <?= $head ?></h3>
<hr/>
<div class="btn btn-success" style="float:right;" id="add_new">
    <span class=" glyphicon glyphicon-plus"></span> เพิ่มผู้ใช้งานระบบ</div>

<table width="100%" id="tb_mas_menu" class="table table-striped">
    <thead>
        <tr>
            <th align="left">#</th>
            <th align="left">ชื่อ - นามสกุล</th>
            <th align="left">Username</th>
            <th style="text-align: center;">Status</th>
            <th style="text-align: center;"></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($user->result() as $rs):
            ?>
            <tr>
                <td><?= $i++ ?></td>
                <td align="left"><?= $rs->name . ' - ' . $rs->lname ?></td>
                <td align="left"><?= $rs->username ?></td>
                <td style=" text-align: center;">
                    <?php
                    if ($rs->status == 'S') {
                        echo "SuperAdmin";
                    } else {
                        echo "Admin";
                    }
                    ?>
                </td>
                <td style=" text-align: center;">
                    <?php if ($rs->status != 'S') { ?>
                        <?php if ($rs->block == '0') { ?>
                            <button type="button" class="btn btn-success btn-block" onclick="blockuser('<?php echo $rs->user_id ?>', '1')">บล็อกผู้ใช้งาน</button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-danger btn-block" onclick="blockuser('<?php echo $rs->user_id ?>', '0')">ปลดบล็อกผู้ใช้งาน</button>
                        <?php } ?>
                    <?php } ?>
                </td>
                <td align="right">
                    <?php if ($rs->status != 'S') { ?>
                        <a href="<?= site_url('backend/users/from_permissions/' . $rs->user_id) ?>" title="แก้ไข"><i class="fa fa-pencil btn btn-info"></i></a>
                        <a href="javascript:delete_user('<?php echo $rs->user_id ?>')" title="ลบ"><i class="fa fa-trash btn btn-danger"></i></a>
                    <?php } else { ?>
                        <a href="<?= site_url('backend/users/from_permissions/' . $rs->user_id) ?>" title="แก้ไข"><i class="fa fa-pencil btn btn-info"></i></a>
                    <?php } ?>
                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- 
        ###### Modal Insert User ###### 
-->

<div id="box-add-user" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="from" name="from" action="<?= site_url('backend/users/save_user') ?>" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">เพิ่มผู้ใช้งานระบบ</h3>
                </div>
                <div class="modal-body">
                    <label>*ชื่อ</label>
                    <input type="text" id="name" name="name" style="width:98%;" required="required" class="form-control"/>
                    <label>*นามสกุล</label>
                    <input type="text" id="lname" name="lname" style="width:98%;" required="required" class="form-control"/>
                    <label>อีเมล์</label>
                    <input type="email" id="email" name="email" style="width:98%;" class="form-control"/>
                    <label>บัตรประชาชน</label>
                    <input type="text" id="card" name="card" style="width:98%;" class="form-control" maxlength="13"/>
                    <label>*username</label>
                    <input type="text" id="username" name="username" style="width:98%;" required="required" class="form-control"/>
                    <label>*password</label>
                    <input type="password" id="password" name="password" style="width:98%;" required="required" class="form-control"/>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success" value="บันทึกข้อมูล" />
                    <input type="reset" class="btn btn-danger" value="ยกเลิก" />
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function delete_user(Id) {
        swal({title: "Are you sure?",
            text: "ต้องการลบผู้ใช้คนนี้ใช่ หรือ ไม่!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false},
                function () {
                    var url = "<?php echo site_url('backend/users/del_user') ?>";
                    var id = Id;
                    var data = {id: id};
                    $.post(url, data, function (success) {
                        window.location.reload();
                    });
                    //swal("Deleted!", "Your imaginary file has been deleted.", "success");
                });
    }

    function blockuser(user_id, type) {
        var url = "<?php echo site_url('backend/users/block') ?>";
        var data = {user_id: user_id, type: type};
        $.post(url, data, function (datas) {
            window.location.reload();
        });
    }
</script>

