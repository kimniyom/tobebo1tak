
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

<h3><i class="fa fa-bookmark"></i> <?php echo $head ?></h3>
<hr/>
<h4>เพิ่มหัวข้อ</h4>
<div class="well well-sm">

    <form id="from" name="from" action="<?php echo site_url('takmoph_admin/save_dengue/') ?>" method="post">
        <label>หัวข้อ</label>
        <input type="hidden" id="group" name="group" value="<?php echo $head; ?>"/>
        <input type="hidden" id="admin_menu_id" name="admin_menu_id" value="<?php echo $admin_menu_id ?>"/>
        <input type="text" id="title" name="title" style="width:98%;" required="required" class="form-control input-sm"/>
        <label>ผู้เผยแพร่</label>
        <input type="text" id="user_" name="user_" style="width:98%;" class="form-control input-sm"
               value="<?php echo $this->session->userdata('name') . '-' . $this->session->userdata('lname'); ?>" readonly="readonly"/>
        <br/>
        <input type="submit" class="btn btn-success" value="บันทึกข้อมูล" />
        <input type="reset" class="btn btn-danger" value="ยกเลิก" />
    </form>
    <br/>
    <p style=" color: #ff0000;">
        <i class="fa fa-info"></i> ท่านจะสามารถแนบไฟล์ได้ก็ต่อเมื่อท่านบันทึกในส่วนนี้เสร็จ
    </p>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo $head ?>
    </div>
    <div class="panel-body">
        <table width="100%" class="table" id="danger">
            <thead>
                <tr style="height:40px;">
                    <th align="left" width="2%">#</th>
                    <th align="left">หัวข้อ</th>
                    <th align="left" width="10%">ไฟล์</th>
                    <?php if ($this->session->userdata('status') != "") { ?>
                        <th width="10%"></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($dengue->result() as $rs):
                    ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td align="left"><?= $rs->title ?></td>
                        <td align="center">
                            <?php if (!empty($rs->file)) { ?>
                                <a href="<?php echo base_url() ?>file_download/<?= $rs->file ?>" target="_blank">
                                    <div class="btn btn-default btn-xs">
                                        <i class=" glyphicon glyphicon-download-alt"></i> Download
                                    </div></a>
                            <?php } else { ?>
                                ไฟล์ไม่มี
                            <?php } ?>
                        </td>
                        <?php if ($this->session->userdata('status') != "") { ?>
                            <td>
                                <div class="btn-group" style=" text-align:left;">
                                    <a class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown" href="#">
                                        <span class=" glyphicon glyphicon-cog"></span> จัดการ <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="Javascript:delete_danger('<?php echo $rs->id; ?>','<?php echo $admin_menu_id ?>');">
                                                <span class=" glyphicon glyphicon-trash"></span> ลบ</a></li>
                                    </ul>
                                </div>
                            </td>
                        <?php } ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


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
            var url = "<?php echo site_url('takmoph_admin/delete_dendue') ?>";
            var data = {id: id, admin_menu: admin_menu};
            $.post(url, data, function (success) {
                window.location.reload();
            });
        }
    }
</script>