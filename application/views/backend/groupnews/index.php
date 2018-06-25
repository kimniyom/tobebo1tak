<style type="text/css">
    #box-add-groupnews .row{
        margin-bottom: 10px;
    }
    #box-edit-groupnews .row{
        margin-bottom: 10px;
    }
</style>
<?php $path = base_url() . "assets/CK-Editor/"; ?>
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
            <span class=" glyphicon glyphicon-plus"></span> เพิ่มกลุ่ม
        </button>
    </div>

    <table width="100%" id="tb_mas_menu" class="table table-striped">
        <thead>
            <tr style="background: #FFF;">
                <th style=" width: 5%; text-align: center;">#</th>
                <th style=" text-align: center; width: 5%;">รหัส</th>
                <th align="left">ชื่อกลุ่ม</th>
                <th style=" text-align: center;">จำนวนหน้า</th>
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
                $this->db->where("groupnews", $rs->id);
                $countNews = $this->db->count_all_results("tb_news");
                ?>
                <tr>
                    <td style=" text-align: center;"><?= $i++ ?></td>
                    <td style=" text-align: center;"><?php echo $rs->id ?></td>
                    <td align="left">
                        <a href="<?php echo site_url('backend/news/get_news/' . $rs->id) ?>"><?= $rs->groupname ?></a>
                    </td>
                    <td style=" text-align: center;"><?php echo $countNews ?></td>
                    <td style=" text-align: center;">
                        <?php if ($rs->active == 1) { ?>
                            <input type="checkbox" id="active" name="active" checked="checked" onclick="set_unactive('<?php echo $rs->id ?>', '0')"/>
                        <?php } else { ?>
                            <input type="checkbox" id="active" name="active" onclick="set_active('<?php echo $rs->id ?>', '1')"/>
                        <?php } ?>
                    </td>
                    <td style="width: 15%; text-align:center;">
                        <button type="button" class="btn btn-default btn-xs up"><i class="fa fa-chevron-up text-success"></i>ขึ้น</button>
                        <button type="button" class="btn btn-default btn-xs down"><i class="fa fa-chevron-down text-warning"></i>ลง</button>
                    </td>
                    <td style=" width: 20%; text-align: center;">
                        <button type="button" class="btn btn-default btn-xs"
                                onclick="update('<?php echo $rs->id; ?>');">
                            <i class="fa fa-edit"></i> แก้ไข
                        </button>
                        <button type="button" class="btn btn-default btn-xs"
                                onclick="delete_groupnews('<?= $rs->id ?>');">
                            <i class="fa fa-trash"></i> ลบ
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
                    <h4 id="myModalLabel"><i class="fa fa-plus-circle"></i> เพิ่มกลุ่ม</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <label>ชื่อกลุ่ม</label>
                            <input type="text" id="groupname" name="groupname" required="required" class="form-control" onkeyup="sethead(this.value)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <label>สีหัวข้อ</label>
                            <input type="color" id="headcolor" value="#eeeeee"/>
                            <label>สีหัวพื้นหลัง</label>
                            <input type="color" id="background" value="#333333"/>

                            <button type="button" onclick="setcolor()"><i class="fa fa-check"></i> ดูตัวอย่าง</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-lg-2">
                            <label>จำนวน Column</label>
                        </div>
                        <div class="col-md-2 col-lg-2">
                            <select id="column" class="form-control" onchange="setcolumns()">
                                <option value="3">4</option>
                                <option value="12">1</option>
                                <option value="6">2</option>
                                <option value="4">3</option>
                            </select>
                        </div>
                    </div>
                

                <div class="row" style=" display: none;">
                    <div class="col-md-6 col-lg-6">
                        <label>ผู้เผยแพร่</label>
                        <input type="text" id="user_" name="user_" class="form-control"
                               value="<?= $this->session->userdata('name') . '-' . $this->session->userdata('lname'); ?>" readonly="readonly"/>
                    </div>
                </div>

                <label>ตัวอย่าง</label>
                <div class="ex" style=" padding: 10px; padding-top: 5px;">
                    <div class="btn" id="_head" style=" border-radius: 0px; font-size: 20px; padding-left: 0px;"><b>ชื่อกลุ่ม</b></div>
                    <hr id="_hr" style=" margin: 0px; margin-bottom: 10px;"/>
                    <div id="_ex"></div>
                </div>
        </div>
        <div class="modal-footer">
            <input type="button" class="btn btn-success" value="บันทึกข้อมูล" onclick="save()"/>
            <input type="reset" class="btn btn-danger" value="ยกเลิก" />
        </div>
        </form>
    </div>
</div>
</div>


<!-- Edit -->
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
    $(document).ready(function () {
        $("#add_groupnew").click(function () {
            setcolumns();
            setcolor();
            $("#box-add-groupnews").modal();
        });
    });

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
            setcolumnsupdate();
            setcolorupdate();
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

    function setlastnews(val) {
        var url = "<?php echo site_url('backend/groupnews/setlastnews') ?>";
        var data = {val: val};
        $.post(url, data, function (datas) {
            window.location.reload();
        });
    }


    function setcolumns() {
        var culumns = $("#column").val();
        var colselect = (12 / culumns);
        var col = "";
        var buttonS = "<button type='button' class='btn btn-default btn-block'><h1><i class='fa fa-photo'></i></h1><hr/>";
        var buttonE = "</button>";
        for (i = 1; i < colselect + 1; i++) {
            col += "<div class='col-lg-" + culumns + "'>" + buttonS + i + buttonE + "</div>";
        }
        var ex = "<div class='row'>" + col + "</div>";
        $("#_ex").html(ex);
    }

    function sethead(text) {
        $(".ex #_head").html("<b>" + text + "</b>");
    }

    function setcolor() {
        var bg = $("#background").val();
        var text = $("#headcolor").val();
        var border = 'solid 2px ' + text;
        $(".ex").css({'background': bg});
        $(".ex #_head").css({'color': text});
        $(".ex #_hr").css({'border': border});
    }


</script>



