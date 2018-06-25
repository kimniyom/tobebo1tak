<script type="text/javascript">
    function add_sub_menu(mas_id) {
        $('#add_sub_menu').modal();
    }

    $(document).ready(function () {
        $("#type_sub_menu").change(function () {
            var type = $("#type_sub_menu").val();
            if (type == 1) {
                $("#show_link").show();
                return false;
            } else {
                $("#show_link").hide();
                return false;
            }
        });
    });

</script>

<script type="text/javascript">
    function edit_sub_menu(sub_id) {
        var url = "<?= site_url('menager_menu/from_edit_sub_menu') ?>";
        var data = {sub_id: sub_id};

        $.post(url, data,
                function (success) {
                    $("#b_body").html(success);
                    $('#myModal').modal();
                });// Endpost
    }
</script>

<script type="text/javascript">
    function delete_sub_menu(sub_id) {
        var r = confirm('Are yor sure ...');
        if (r == true) {
            var url = "<?= site_url('menager_menu/delete_submenu') ?>";
            var data = {sub_id: sub_id};

            $.post(url, data,
                    function (success) {
                        window.location.reload();
                    });// Endpost
        }
    }
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
    array('url' => 'menager_menu/get_mas_menu', 'label' => 'เมนูเว็บไซต์')
);

$active = $head;
echo $model->breadcrumb_backend($list, $active);
?>



<h3><i class="fa fa-sitemap"></i> <?= $head ?></h3>
<hr/>
<span style=" color: #ff0000;">*เพิ่มไฟล์คลิกที่ชื่อหัวข้อ</span>
<button type="button" class="btn btn-default" style="float:right;" onclick="add_sub_menu('<?= $mas_id ?>');">
    <span class="fa fa-plus"></span> เพิ่มเมนูย่อย
</button>

<table width="100%" id="tb_mas_menu" class="table">
    <thead>
        <tr>
            <th align="left">#</th>
            <th align="left">เมนูย่อย</th>
            <!--
            <th align="left">ลิงค์/file</th>
            -->
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($sub_menu->result() as $rs):
            $url = array('menager_menu/view', $rs->sub_id, $rs->mas_id);
        $users = $this->user->view($rs->owner);
            ?>
            <tr>
                <td style=" width: 5%;"><?= $i++ ?></td>
                <td align="left">
                    <a href="<?php echo site_url($url) ?>">
                        <?= $rs->sub_name ?></a>
                    <em style=" color: #999999;">(โดย : <?php echo $users->name . ' ' . $users->lname ?>)</em>
                </td>
                <!--
                <td align="left">
                <?php //if ($rs->file != '') { ?>

                <?php //} else { ?>
                        <?//= $rs->link ?>
                <?php //} ?>
                </td>
                -->
                <td style=" width: 10%;">
                    <a href="#" onclick="edit_sub_menu('<?= $rs->sub_id ?>');">
                        <span class=" glyphicon glyphicon-edit"></span> แก้ไข</a>
                    <a href="javascript:delete_sub_menu('<?= $rs->sub_id ?>')">
                        <span class=" glyphicon glyphicon-trash"></span> ลบ</a>

                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<!--- 
    #### Insert Update Delete ####
---->

<!--- Insert ---->
<div id="add_sub_menu" class="modal fade">
    <div class=" modal-dialog">
        <div class=" modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 id="myModalLabel">เพิ่มเมนูย่อย[<?= $row->mas_menu ?>]</h4>
            </div>
            <div class="modal-body">
                <form id="add_menu" action="<?= site_url('menager_menu/add_sub_menu') ?>" method="post">
                    <input type="hidden" id="mas_id" name="mas_id" value="<?= $mas_id ?>"/>
                    เมนู :<br />
                    <input type="text" id="sub_name" name="sub_name" required="required" class="form-control input-sm"/>
                    <br /> ประเภท :<br />
                    <select id="type_sub_menu" name="type_sub_menu" class="form-control">
                        <option value="0">ไฟล์</option>
                        <!--
                        <option value="1">ลิงค์</option>
                        -->
                    </select>
                    <div id="show_link" style="display:none;">
                        ลิงค์ :<br />
                        <input id="_link" name="_link" type="text" class="form-control input-sm" style="color:#000000;"/>
                    </div>
                    <br /> 
                    <input type="submit" value="บันทึกข้อมูล" class="btn btn-success" style="margin-bottom:10px;"/>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>


<!---- Update ----->
<div id="myModal" class="modal fade">
    <div class=" modal-dialog">
        <div class=" modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 id="myModalLabel">แก้ไขเมนู</h4>
            </div>
            <div class="modal-body" id="b_body"></div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button class="btn btn-primary" id="save_edit_submenu">Save changes</button>
            </div>
        </div>
    </div>
</div>


