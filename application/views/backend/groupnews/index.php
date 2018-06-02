<?php $path = base_url() . "assets/CK-Editor/"; ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#add_groupnew").click(function () {
            $("#box-add-groupnews").modal();
        });
    });
</script>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#tb_mas_menu').dataTable({
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
<div class="panel panel-default">
    <div class="panel-heading">
        <?php if ($lastnewshow == 1) { ?>
            <input type="checkbox" id="lastnews" checked="checked" onclick="setlastnews(0)"/> 
        <?php } else { ?>
            <input type="checkbox" id="lastnews" onclick="setlastnews(1)"/> 
        <?php } ?>
        แสดงข้อมูลล่าสุดหน้าเว็บ | 
        <button type="button" class="btn btn-success btn-sm" id="add_groupnew">
            <span class=" glyphicon glyphicon-plus"></span> เพิ่มกลุ่มข่าวประชาสัมพันธ์
        </button>
    </div>
    <table width="100%" id="tb_mas_menu" class="table table-striped">
        <thead>
            <tr style=" background: #FFF;">
                <th align="left" style=" width: 5%;">#</th>
                <th style=" text-align: center; width: 5%;">รหัส</th>
                <th align="left">ชื่อกลุ่มข่าว</th>
                <th style=" text-align: center;">Active</th>
                <th style=" text-align: center;">
                    <button type="button" class="btn btn-default btn-sm" onclick="save_sort_order()"><i class="fa fa-save text-primary"></i> บันทึก</button>
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($groupnews->result() as $rs):
                ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td style=" text-align: center;"><?php echo $rs->id ?></td>
                    <td align="left">
                        <a href="<?php echo site_url('backend/news/get_news/' . $rs->id) ?>"><?= $rs->groupname ?></a>
                    </td>
                    <td style=" text-align: center;">
                        <?php if ($rs->active == 1) { ?>
                            <input type="checkbox" id="active" name="active" checked="checked" onclick="set_unactive('<?php echo $rs->id ?>', '0')"/>
                        <?php } else { ?>
                            <input type="checkbox" id="active" name="active" onclick="set_active('<?php echo $rs->id ?>', '1')"/>
                        <?php } ?>
                    </td>
                    <td style="width: 15%; text-align:center;">
                        <button type="button" class="btn btn-default btn-sm up"><i class="fa fa-chevron-up text-success"></i>ขึ้น</button>
                        <button type="button" class="btn btn-default btn-sm down"><i class="fa fa-chevron-down text-warning"></i>ลง</button>
                    </td>
                    <td style=" width: 20%; text-align: center;">
                        <button type="button" class="btn btn-default btn-sm"
                                onclick="update('<?php echo $rs->id; ?>');">
                            <span class=" glyphicon glyphicon-edit"></span> แก้ไข
                        </button>
                        <button type="button" class="btn btn-default btn-sm"
                                onclick="delete_groupnews('<?= $rs->id ?>');">
                            <span class=" glyphicon glyphicon-trash"></span> ลบ
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- 
    Add Edit Delete 
-->

<div id="box-add-groupnews" class="modal fade  bs-example-modal-lg" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="from" name="from">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 id="myModalLabel"><i class="fa fa-plus-circle"></i> เพิ่มกลุ่มข่าว</h4>
                </div>
                <div class="modal-body">
                    <label>ชื่อกลุ่ม</label>
                    <input type="text" id="groupname" name="groupname" style="width:98%;" required="required" class="form-control input-mini"/>
                    <br/>
                    <label>สีหัวข้อ</label>
                    <input type="color" id="headcolor" value="#eeeeee"/>
                    <label>สีหัวพื้นหลัง</label>
                    <input type="color" id="background" value="#FFFFFF"/>
                    <br/>
                    <label>จำนวน Column</label>
                    <select id="column" class="form-control">
                        <option value="3">4</option>
                        <option value="12">1</option>
                        <option value="6">2</option>
                        <option value="4">3</option>
                    </select>

                    <label>ผู้เผยแพร่</label>
                    <input type="text" id="user_" name="user_" style="width:98%;"  class="form-control input-mini"
                           value="<?= $this->session->userdata('name') . '-' . $this->session->userdata('lname'); ?>" readonly="readonly"/>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-success" value="บันทึกข้อมูล" onclick="save()"/>
                    <input type="reset" class="btn btn-danger" value="ยกเลิก" />
                </div>
            </form>
        </div>
    </div>
</div>

<div id="box-edit-groupnews" class="modal fade  bs-example-modal-lg" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 id="myModalLabel"><i class="fa fa-pencil"></i> แก้ไข</h4>
            </div>
            <div class="modal-body">
                <div id="from-edit"></div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-success" value="บันทึกข้อมูล" onclick="edit_groupnews()"/>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function save() {
        var groupname = $("#groupname").val();
        var headcolor = $("#headcolor").val();
        var background = $("#background").val();
        var column = $("#column").val();
        var data = {
            groupname: groupname,
            headcolor: headcolor,
            background: background,
            column: column
        };

        if (groupname == "") {
            $("#groupname").focus();
            return false;
        }
        $.ajax({
            type: "POST",
            url: "<?= site_url('backend/groupnews/save') ?>",
            data: data,
            success: function () {
                window.location.reload();
            }
        });
    }

    function update(id) {
        var url = "<?php echo site_url('backend/groupnews/update') ?>";
        var data = {id: id};
        $.post(url, data, function (datas) {
            $("#box-edit-groupnews").modal();
            $("#from-edit").html(datas);
        });
    }

    function delete_groupnews(groupid) {
        var r = confirm("คุณแน่ใจหรือไม่...?");
        if (r == true) {
            var url = "<?php echo site_url('backend/groupnews/delete'); ?>";
            var data = {id: groupid};

            $.post(url, data, function (success) {
                window.location.reload();
            });
        }
    }
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $(".up,.down").click(function () {
            var row = $(this).parents("tr:first");
            if ($(this).is(".up")) {
                row.insertBefore(row.prev());
            } else {
                row.insertAfter(row.next());
            }
        });
    });

    function save_sort_order() {
        var table = document.getElementById('tb_mas_menu');

        var rowLength = table.rows.length;
        var a = 0;
        for (var i = 1; i < rowLength; i += 1) {
            var rows = table.rows[i];
            var level = i;
            var id = parseInt(rows.cells[1].innerText);
            //alert(id);
            //alert(level + "=>" + title);
            var url = "<?php echo site_url('backend/groupnews/set_level') ?>";
            var data = {
                id: id, level: level
            };

            $.post(url, data, function (success) {
                a = (a += 1);
                //$("#log").append(success + "<br/>");
                if (a >= (rowLength - 1)) {
                    window.location.reload();
                }
            });

            //your code goes here, looping over every row.
            //cells are accessed as easy
            /*
             var cellLength = row.cells.length;
             for(var y=0; y<cellLength; y+=1){
             var cell = row.cells[y];
             
             //do something with every cell here
             }
             */
        }
    }

    function set_active(id, active) {
        var url = "<?php echo site_url('backend/groupnews/set_active') ?>";
        var data = {id: id, active: active};
        $.post(url, data, function (success) {
            window.location.reload();
        });
    }

    function set_unactive(id, active) {
        var url = "<?php echo site_url('backend/groupnews/set_unactive') ?>";
        var data = {id: id, active: active};
        $.post(url, data, function (success) {
            window.location.reload();
        });
    }
    
    function setlastnews(val){
        var url = "<?php echo site_url('backend/groupnews/setlastnews') ?>";
        var data = {val: val};
        $.post(url,data,function(datas){
            window.location.reload();
        });
    }
</script>



