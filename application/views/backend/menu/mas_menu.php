
<style type="text/css">
    .t_box{ width:97%;}
</style>
<script type="text/javascript">
    function edit_mas_menu(mas_id) {
        var url = "<?= site_url('menager_menu/from_edit_menu') ?>";
        var data = {mas_id: mas_id};

        $.post(url, data,
                function (success) {
                    $("#load_edit_menu").html(success);
                    $('#myModal').modal();
                }
        );// Endpost
    }
</script>

<script type="text/javascript">
    function del_mas_menu(mas_id) {
        $('#confrim').modal();
        $("#del_mas_menu").click(function () {
            var url = "<?= site_url('menager_menu/delete_mas_menu') ?>";
            var data = {mas_id: mas_id};

            $.post(url, data,
                    function (success) {
                        window.location.reload();
                    }
            );// Endpost
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
    function select_icon(Id) {
        var url = "<?= site_url('menager_menu/get_icon') ?>";
        var icon_id = Id;
        var data = {icon_id: icon_id};
        $("#icon_id").val(Id);
        $.post(url, data,
                function (success) {
                    $("#icon_show_add").html(success);
                }
        );//endpost
    }

    $(document).ready(function () {


        /*
         $("#icon_id").change(function () {
         var url = "<?//= site_url('menager_menu/get_icon') ?>";
         var icon_id = $("#icon_id").val();
         var data = {icon_id: icon_id};
         $.post(url, data,
         function (success) {
         $("#icon_show_add").html(success);
         }
         );//endpost
         });
         */

        $("#mas_status").change(function () {
            var mas_status = $("#mas_status").val();
            if (mas_status == '0') {
                $("#box_link_out").hide();
                $("#box_link").show(function () {
                    var url = "<?php echo site_url('menager_menu/GetUncheckMenu/') ?>";
                    var data = {a: 1};
                    $.post(url, data, function (success) {
                        $("#linkmenu").html(success);
                    });
                });
                return false;
            } else if (mas_status == '1') {
                var _link = "";
                $("#box_link").hide();
                $("#box_link_out").hide();
            } else {
                $("#box_link_out").show();
            }

        });

    });

    function save_menu() {
        var url = "<?= site_url('menager_menu/save_menu') ?>";
        var mas_menu = $("#mas_menu").val();
        var mas_status = $("#mas_status").val();
        var bgcolor = $("#bgcolor").val();
        var textcolor = $("#textcolor").val();
        var icon_id = $("#icon_id").val();
        var _link = $("#link").val();
        var link_out = $("#link_out").val();

        if (mas_menu == '') {
            alert("กรอกข้อมูลไม่ครบ ...");
            return false;
        }

        if (bgcolor == '') {
            alert("ยังไม่ได้เลือกสี ...");
            return false;
        }

        if (icon_id == '') {
            alert("ยังไม่ได้เลือก Icon ...");
            return false;
        }

        if (mas_status == '') {
            alert("ยังไม่ได้เลือกประเภทลิงค์ ...");
            return false;
        }

        var data = {
          mas_menu: mas_menu,
          mas_status: mas_status,
          bgcolor: bgcolor,
          textcolor: textcolor,
          _link: _link,
          icon_id: icon_id,
          link_out: link_out
        };

        $.post(url, data,
                function (success) {
                    window.location.reload();
                }
        );// Endpost
    }
</script>




<!-- ############ -->
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
        //array('url' => '', 'label' => 'menu2')
);

$active = $head;
?>
<div class="row" style=" margin: 0px; padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 0px;">
        <h3 id="head_submenu"><i class="fa fa-list-alt"></i> <?php echo $head ?></h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-right: 0px;">
        <?php echo $model->breadcrumb_backend($list, $active); ?>
    </div>
</div>

<hr id="hr"/>


<a href="javascript:void(0);" id="c_insert"><div class="btn btn-default" style=" float:right;">
        <span class=" glyphicon glyphicon-plus"></span> เพิ่มเมนู</div></a>

<table id="tb_mas_menu" class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>รหัส</th>
            <th align="left">เมนู</th>
            <th align="left">ประเภท</th>
            <th>สี</th>
            <th>ไอคอน</th>
            <th align="left">ลิงค์</th>
            <th align="center" style=" width: 10%;">ลำดับ</th>
            <th></th>
            <th style="text-align:right;">
              <button type="button" class="btn btn-default btn-sm" onclick="save_sort_order()"><i class="fa fa-save text-primary"></i> บันทึก</button>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($mas_menu->result() as $rs):?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?php echo $rs->id ?></td>
                <td align="left">
                    <?php if ($rs->mas_status == '1') { ?>
                        <a href="<?= site_url('menager_menu/get_sub_menu/' . $rs->id); ?>"><?= $rs->mas_menu ?></a>
                    <?php } else { ?>
                        <?= $rs->mas_menu ?>
                    <?php } ?>
                </td>
                <td align="left"><?php
                    if ($rs->mas_status == '0') {
                        echo "Link";
                    } else {
                        echo "DropDown";
                    }
                    ?></td>
                <td><div class="btn" style="background:<?php echo $rs->bgcolor ?>;color:<?php echo $rs->textcolor ?>;">&nbsp;</div></td>
                <td><img src="<?= base_url() ?>icon_menu/<?= $rs->menu_icon ?>" style=" width: 32px;"/></td>
                <td align="left"><?php
                    if ($rs->mas_status == '0') {
                        echo $rs->link;
                    } else if ($rs->mas_status == '1') {
                        echo "DropDown";
                    } else {
                        echo $rs->link_out;
                    }
                    ?></td>
                <td>
                    <input type="text" id="lever" value="<?= $rs->level ?>" style="width:50px;" class=" form-control input-sm" readonly="readonly"
                           onclick="set_level('<?= $rs->id ?>', '<?= $rs->level ?>');"/>
                </td>
                <td>
                    <div class="btn-group" style=" text-align:left;">
                        <a class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" href="javascript:void(0);">
                            <span class=" glyphicon glyphicon-cog"></span> จัดการ <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#" onclick="edit_mas_menu('<?= $rs->id ?>');"><span class=" glyphicon glyphicon-edit"></span> แก้ไข</a></li>
                            <li><a href="#" onclick="del_mas_menu('<?= $rs->id ?>');"><span class=" glyphicon glyphicon-trash"></span> ลบ</a></li>
                        </ul>
                    </div>
                </td>
                <td style="width: 15%; text-align:right;">
                  <button type="button" class="btn btn-default btn-sm up"><i class="fa fa-chevron-up text-success"></i>ขึ้น</button>
                  <button type="button" class="btn btn-default btn-sm down"><i class="fa fa-chevron-down text-warning"></i>ลง</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<div id="confrim" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 id="myModalLabel">!แจ้งเตือน</h4>
            </div>
            <div class="modal-body"><img src="<?= base_url() ?>images/warning-icon.png"/> คุณต้องการลบเมนูนี้ ใช่ หรือ ไม่</div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                <button class="btn btn-primary" id="del_mas_menu">Ok</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 id="myModalLabel">แก้ไขเมนู</h4>
            </div>
            <div class="modal-body"><div id="load_edit_menu"></div></div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button class="btn btn-primary" id="save_edit">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- POPUP Insert Menu -->
<div class="modal fade" id="Insert_menu">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 id="myModalLabel">เพิ่มเมนู</h4>
            </div>
            <div class="modal-body">

                    <div class="form-group">
                        <label for="exampleInputEmail1">เมนู : </label>
                        <input type="text" id="mas_menu" class="form-control input-sm"/>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">ไอคอน : </label>
                        <div class="row">
                            <div class="col-lg-9 col-sm-9 col-md-9">
                                <input type="hidden" id="icon_id"/>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <i class="fa fa-smile-o"></i> เลือก icon
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style=" max-height: 300px; overflow: auto;">
                                        <?php foreach ($icon->result() as $rs): ?>
                                            <li>
                                                <a href="javascript:select_icon('<?php echo $rs->icon_id ?>')"><img src="<?php echo base_url() ?>icon_menu/<?php echo $rs->icon ?>" width="32"/><?php echo $rs->icon ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-md-3">
                                <div class="btn btn-default" id="icon_show_add" style="margin-bottom:0px; padding: 5px;">
                                    <i class="fa fa-smile-o fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>


                    <label for="exampleInputEmail1">สีเมนู : </label>
                    <div class="row">
                      <div class="col-sm-12 col-md-10 col-lg-10">
                        <button type="button" class="btn" style="background:#ff8981; color:#ff8981;" onclick="set_btn_color('#ff8981','#000000')">l</button>
                        <button type="button" class="btn" style="background:#b58aff; color:#b58aff;" onclick="set_btn_color('#b58aff','#000000')">.</button>
                        <button type="button" class="btn" style="background:#b9f6cc; color:#b9f6cc;" onclick="set_btn_color('#b9f6cc','#000000')">.</button>
                        <button type="button" class="btn" style="background:#fffe8d; color:#fffe8d;" onclick="set_btn_color('#fffe8d','#000000')">.</button>
                        <button type="button" class="btn" style="background:#84feff; color:#84feff;" onclick="set_btn_color('#84feff','#000000')">.</button>
                        <button type="button" class="btn" style="background:#f5f5f5; color:#f5f5f5;" onclick="set_btn_color('#f5f5f5','#000000')">.</button>

                        <button type="button" class="btn" style="background:#ff5254; color:#ff5254;" onclick="set_btn_color('#ff5254','#FFFFFF')">.</button>
                        <button type="button" class="btn" style="background:#7e57c2; color:#7e57c2;" onclick="set_btn_color('#7e57c2','#FFFFFF')">.</button>
                        <button type="button" class="btn" style="background:#1de9b6; color:#1de9b6;" onclick="set_btn_color('#1de9b6','#000000')">.</button>
                        <button type="button" class="btn" style="background:#ffeb3c; color:#ffeb3c;" onclick="set_btn_color('#ffeb3c','#000000')">.</button>
                        <button type="button" class="btn" style="background:#05a8f3; color:#05a8f3;" onclick="set_btn_color('#05a8f3','#FFFFFF')">.</button>
                        <button type="button" class="btn" style="background:#999999; color:#999999;" onclick="set_btn_color('#999999','#FFFFFF')">.</button>
                  </div>
                  <div class="col-sm-12 col-md-2 col-lg-2">
                    <div class="btn btn-block" id="bg_color">ตัวอย่าง</div>
                  </div>
                  <input type="hidden" id="bgcolor"/>
                  <input type="hidden" id="textcolor"/>
                  </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">ประเภท : </label>
                        <select  id="mas_status" class="form-control input-sm">
                            <option value="">== กรุณาเลือก ==</option>
                            <option value="0">ลิงค์ในระบบ</option>
                            <option value="1">มีเมนูย่อย</option>
                            <option value="2">ลิงค์ไปยังเว็บไซต์ภายนอก</option>
                        </select><br />
                        <div id="box_link" style="display:none;">
                            ลิงค์ : <br />
                            <div id="linkmenu"></div>
                        </div>

                        <div id="box_link_out" style="display:none;">
                            Url ลิงค์ข้างนอก : <br />
                            <input type="text" id="link_out" class=" form-control"/>
                        </div>

                    </div>

            </div><!-- modal body -->
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button class="btn btn-primary" onclick="save_menu()">Save changes</button>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    $(document).ready(function(){
        $(".up,.down").click(function(){
            var row = $(this).parents("tr:first");
            if ($(this).is(".up")) {
                row.insertBefore(row.prev());
            } else {
                row.insertAfter(row.next());
            }
        });
    });

    function save_sort_order(){
        var table = document.getElementById('tb_mas_menu');

          var rowLength = table.rows.length;
          var a = 0;
          for(var i=1; i<rowLength; i+=1){
            var rows = table.rows[i];
            var level = i;
            var id = parseInt(rows.cells[1].innerText);
            //alert(level + "=>" + title);
            var url = "<?php echo site_url('menager_menu/set_level')?>";
            var data = {
              id: id,level: level
            }

            $.post(url,data,function(success){
              a = (a+=1);
              //$("#log").append(success + "<br/>");
              if(a >= (rowLength-1)){
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

    function set_btn_color(color,text){
      $("#bgcolor").val(color);
      $("#textcolor").val(text);
      var style = {
        "background": color,
        "color": text
      }
      $("#bg_color").css(style);
    }
</script>
