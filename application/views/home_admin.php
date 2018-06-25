<script type="text/javascript">
    function Addmenu() {
        $("#AddMenu").modal();
    }

    /*
     function GetImg() {
     var url = "<?php //echo site_url('upload_photo/GetImg/')         ?>";
     var data = {a: 1};
     $.post(url, data, function (success) {
     $("#ShowImg").html(success);
     });
     }
     
     function DelImg() {
     var admin_menu_id = $("#admin_menu_id").val();
     if (admin_menu_id != "") {
     var url = "<?php //echo site_url('upload_photo/DelImgAdminMenu/')         ?>";
     var data = {admin_menu_id: admin_menu_id};
     $.post(url, data, function (result) {
     window.location.reload();
     });
     //$("#AddMenu").modal('hide');
     } else {
     $("#AddMenu").modal('hide');
     }
     }
     */
</script>
<script type="text/javascript">
    /*
     $(document).ready(function () {
     $('#file_upload').uploadify({
     'buttonText': 'กรุณาเลือกรูปภาพ ...',
     'auto': true, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
     'swf': '<?php //echo base_url()         ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
     'uploader': '<?php //echo site_url('upload_photo/upload_img_menu_admin/')         ?>', //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
     'fileSizeLimit': '100MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
     //'width': '350',
     //'height': '40',
     'fileTypeExts': '*.jpg; *.JPEG; *.png; *.gif;', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
     'multi': true, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
     'queueSizeLimit': 1, //อัพโหลดได้ครั้งละ 5 ไฟล์
     'onUploadComplete': function (data) { //เมื่ออัพโหลดเสร็จแล้วให้เรียกใช้งาน function load()
     GetImg();
     }
     });
     });
     */
</script>


<!-- Button to trigger modal -->
<?php if ($menu_admin_type->result()) { ?>
    <h3>
        <i class="fa fa-cogs text-info"></i>
        <i class="fa fa-wrench text-info"></i>
        จัดการเว็บไซต์</h3>

    <hr/>

    <div class="row" style=" padding:0px 10px;">
        <?php
        foreach ($menu_admin_type->result() as $rs):
            ?>
            <div class="col-xs-6 col-sm-4 col-md-2 col-lg-2" style=" margin-bottom:0px; padding: 5px;">
                <a href="<?= site_url($rs->admin_menu_link) . '/' . $rs->admin_menu_id . '/' . $rs->admin_menu_name ?>" style=" text-decoration: none;">
                    <div class="btn btn-block" id="btn-icon-menu">
                        <center>
                            <img src="<?= base_url() ?>icon_menu/<?= $rs->admin_menu_images ?>" class="img-responsive" style="max-height: 80px;"/>
                            <?= $rs->admin_menu_name ?>
                        </center>
                    </div>
                </a>
            </div>

        <?php endforeach; ?>
    </div><!-- End row --> 
<?php } ?>

<!--
    ####### Module ########
-->
<h3><i class="fa fa-plug"></i>โมดูล</h3>
<hr/>
<div class="row" style=" padding:0px 10px;">
    <?php
    foreach ($module->result() as $modules) {
        ?>
        <div class="col-xs-6 col-sm-4 col-md-2 col-lg-2" style=" margin-bottom:0px; padding: 5px;">
            <a href="<?= site_url($modules->path) ?>" style=" text-decoration: none;">
                <div class="btn btn-block" id="btn-icon-menu">
                    <center>
                        <img src="<?= base_url() ?>assets/module/<?php echo $modules->module ?>/images/icon.png" class="img-responsive" style="height: 64px;"/>
                        <br/><?php echo $modules->thainame ?>
                    </center>
                </div>
            </a>
        </div>
    <?php } ?>
</div>

<!--
 ######## System Download #########
-->

<h3>
    <i class="fa fa-cogs text-success"></i>
    <i class="fa fa-download text-info"></i>
    เพิ่มเมนูให้กับผู้ใช้งาน / ฝ่าย / หน่วยงานย่อย
    <?php if ($this->session->userdata['status'] == 'S') { ?>
        <button type="button" class="btn btn-success pull-right" onclick="Addmenu();">
            <i class="fa fa-plus"></i> สร้างเมนู
        </button>
    <?php } ?>
</h3>
<hr style=" margin-bottom: 0px;"/>
<div class="alert alert-info">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    :: เป็นการเพิ่มเมนูให้กับผู้ใช้งานระบบหรือ ฝ่าย/หน่วยงานย่อย ที่ต้องการมีเมนูและเนื้อหาที่เป็นของตัวเองโดยใช้งานผ่านเมนูที่ admin เป็นคนกำหนดให้<br/>
    ในส่วน admin เมื่อสร้างเมนูแล้วให้ไปเพิ่มเมนูในระบบ template โดยเข้าไปจัดการที่ 
    <em><font style="color: #000000; font-weight: bold;">"เมนูเว็บไซต์"</font></em> 
    ถ้าไม่กำหนดเมนูจะไม่แสดงหน้าเว็บ การแสดงผลขึ้นอยู่กับ template ที่เลือกใช้งาน::
</div>
<div class="row">
    <?php
    foreach ($menu_admin->result() as $rss):
        if ($rss->typelink == '1') {
            $countpage = $this->db->where('admin_menu_id', $rss->admin_menu_id)
                    ->count_all_results('dengue');
            ?>
            <div class="col-xs-12 col-sm-4 col-md-6 col-lg-4" style=" margin-bottom: 10px;">

                <?php if ($this->session->userdata('status') == 'S') { ?>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <button type="button" class="btn btn-default" onclick="updatemenu('<?php echo $rss->admin_menu_id ?>', '<?php echo $rss->admin_menu_images ?>', '<?php echo $rss->admin_menu_name ?>')" style=" border-radius: 0px; border-bottom: none;">
                                <i class="fa fa-pencil text-warning"></i> แก้ไข
                            </button>
                            <button type="button" class="btn btn-default" onclick="delete_admin_menu('<?php echo $rss->admin_menu_id ?>')" style=" border-radius: 0px; border-bottom: none;">
                                <i class="fa fa-trash text-danger"></i> ลบ
                            </button>
                        </div>
                    </div>
                <?php } ?>

                <a href="<?= site_url($rss->admin_menu_link) . '/' . $rss->admin_menu_id . '/' . $rss->admin_menu_name ?>" style=" text-decoration: none;">
                    <div class="btn btn-default btn-block" style=" text-align: center; border-radius: 0px;">
                        <div class="row">
                            <div class="col-md-10 col-lg-10">
                                <div style="height:48px; float: left;">
                                    <img src="<?= base_url() ?>icon_menu/<?= $rss->admin_menu_images ?>" class="img img-thumbnail" style="max-height: 48px;"/>
                                </div>
                                <div style="float: left; text-align: left; padding-left: 10px;">
                                    <b><?= $rss->admin_menu_name ?></b><br/>
                                    จำนวนข้อมูล <span class=" badge"> <?php echo $countpage ?> </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </a>
            </div>
        <?php } ?>
    <?php endforeach; ?>
</div>

<!---
########## Insert Update Delete #############
--->
<!-- Modal Add Menu Admin-->
<div id="AddMenu" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="myModalLabel"><span id="_icon"></span> เพิ่มเมนู</h4>
            </div>
            <div class="modal-body">
                <label>ชื่อ</label>
                <input type="text" id="admin_menu_name" class=" form-control"/>
                <input type="hidden" id="admin_menu_link" value="backend/pages/getpage" readonly style=" width: 95%;" class=" form-control"/>
                <label>icon</label>
                <div style=" height: 300px; overflow: auto; margin-bottom: 0px;" class="well">
                    <input type="hidden" id="icon"/>
                    <div class="row" style=" margin: 0px;">
                        <?php
                        $resulticon = $this->db->get("menu_icon");
                        foreach ($resulticon->result() as $ic):
                            ?>
                            <div class="col-md-3 col-lg-2 col-sm-3 col-xs-4" style=" margin-bottom: 10px;">
                                <button type="button" class="btn btn-default btn-block" onclick="seticon('<?php echo $ic->icon ?>')">
                                    <center>
                                        <img src="<?php echo base_url() ?>/icon_menu/<?php echo $ic->icon; ?>" style=" height: 32px;" class="img img-responsive"/>
                                    </center>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!--
                <div id="ShowImg">
                    <form>
                        <input id="file_upload" name="file_upload" type="file"/>
                    </form>
                </div>
                -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="SaveMenu();"><i class="fa fa-save"></i> บันทึกข้อมูล</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update -->
<div id="editmenu" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="myModalLabel"><span id="_icons"></span> แก้ไขเมนู</h4>
            </div>
            <div class="modal-body">
                <label>ชื่อ</label>
                <input type="hidden" id="_admin_menu_id" class=" form-control"/>
                <input type="text" id="_admin_menu_name" class=" form-control"/>
                <label>icon</label>
                <div style=" height: 300px; overflow: auto; margin-bottom: 0px;" class="well">
                    <input type="hidden" id="icons"/>
                    <div class="row" style=" margin: 0px;">
                        <?php
                        foreach ($resulticon->result() as $ics):
                            ?>
                            <div class="col-md-3 col-lg-2 col-sm-3 col-xs-4" style=" margin-bottom: 10px;">
                                <button type="button" class="btn btn-default btn-block" onclick="seticons('<?php echo $ics->icon ?>')">
                                    <center>
                                        <img src="<?php echo base_url() ?>/icon_menu/<?php echo $ics->icon; ?>" style=" height: 32px;" class="img img-responsive"/>
                                    </center>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="SaveUpdateMenu();"><i class="fa fa-save"></i> บันทึกข้อมูล</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function delete_admin_menu(id) {
        swal({
            title: "Are you sure?",
            text: "คุณแน่ใจ หรือ ไม่ ข้อมูลที่อยู่ภายใต้เมนูนี้จะถูกลบทั้งหมด!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            var url = "<?php echo site_url('menager_menu/delete_admin_menu') ?>";
            var data = {id: id};
            $.post(url, data, function (success) {
                swal("Deleted!", "Your imaginary file has been deleted.", "success");
                window.location.reload();
            });

        });

    }

    function SaveMenu() {
        var admin_menu_id = $("#admin_menu_id").val();
        var admin_menu_name = $("#admin_menu_name").val();
        var admin_menu_link = $("#admin_menu_link").val();
        var icon = $("#icon").val();
        if (admin_menu_id == "" || admin_menu_name == "" || icon == "") {
            alert("กรุณากรอกข้อมูลให้ครบ ...");
            return false;
        }

        var url = "<?php echo site_url('takmoph_admin/SaveMenuAdmin') ?>";
        var data = {admin_menu_id: admin_menu_id, admin_menu_name: admin_menu_name, admin_menu_link: admin_menu_link, icon: icon};
        $.post(url, data, function (success) {
            window.location.reload();
        });
    }

    function seticon(icon) {
        $("#icon").val(icon);
        var url = "<?php echo base_url() ?>";
        var icons = "<img src='" + url + "/icon_menu/" + icon + "' style='height:24px;'/>";
        $("#_icon").html(icons);
    }

    function updatemenu(id, icon, name) {
        var urlimg = "<?php echo base_url() ?>";
        var icons = "<img src='" + urlimg + "/icon_menu/" + icon + "' style='height:24px;'/>";
        $("#_icons").html(icons);
        $("#_admin_menu_id").val(id);
        $("#_admin_menu_name").val(name);
        $("#icons").val(icon);
        $("#editmenu").modal();
    }

    function seticons(icon) {
        $("#icons").val(icon);
        var url = "<?php echo base_url() ?>";
        var icons = "<img src='" + url + "/icon_menu/" + icon + "' style='height:24px;'/>";
        $("#_icons").html(icons);
    }

    function SaveUpdateMenu() {
        var admin_menu_id = $("#_admin_menu_id").val();
        var admin_menu_name = $("#_admin_menu_name").val();
        var icon = $("#icons").val();
        if (admin_menu_id == "" || admin_menu_name == "" || icon == "") {
            alert("กรุณากรอกข้อมูลให้ครบ ...");
            return false;
        }

        var url = "<?php echo site_url('takmoph_admin/SaveUpdateMenu') ?>";
        var data = {admin_menu_id: admin_menu_id, admin_menu_name: admin_menu_name, icon: icon};
        $.post(url, data, function (success) {
            window.location.reload();
        });
    }
</script>
