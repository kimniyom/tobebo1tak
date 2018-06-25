<script type="text/javascript">
    function Addmenu() {
        $("#AddMenu").modal();
    }

    function SaveMenu() {
        var admin_menu_id = $("#admin_menu_id").val();
        var admin_menu_name = $("#admin_menu_name").val();
        var admin_menu_link = $("#admin_menu_link").val();
        if (admin_menu_id == "" || admin_menu_name == "") {
            alert("กรุณากรอกข้อมูลให้ครบ ...");
            return false;
        }

        var url = "<?php echo site_url('takmoph_admin/SaveMenuAdmin/') ?>";
        var data = {admin_menu_id: admin_menu_id, admin_menu_name: admin_menu_name, admin_menu_link: admin_menu_link};
        $.post(url, data, function (success) {
            window.location.reload();
        });
    }

    function GetImg() {
        var url = "<?php echo site_url('upload_photo/GetImg/') ?>";
        var data = {a: 1};
        $.post(url, data, function (success) {
            $("#ShowImg").html(success);
        });
    }

    function DelImg() {
        var admin_menu_id = $("#admin_menu_id").val();
        if (admin_menu_id != "") {
            var url = "<?php echo site_url('upload_photo/DelImgAdminMenu/') ?>";
            var data = {admin_menu_id: admin_menu_id};
            $.post(url, data, function (result) {
                window.location.reload();
            });
            //$("#AddMenu").modal('hide');
        } else {
            $("#AddMenu").modal('hide');
        }
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#file_upload').uploadify({
            'buttonText': 'กรุณาเลือกรูปภาพ ...',
            'auto': true, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('upload_photo/upload_img_menu_admin/') ?>', //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
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
<hr/>
<!--
 ######## System Download #########
-->

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 style="margin:0px;">
            <i class="fa fa-cogs text-success"></i>
            <i class="fa fa-download text-info"></i>
            ระบบไฟล์ Download
            <?php if ($this->session->userdata['status'] == 'S') { ?>
                <button type="button" class="btn btn-success" onclick="Addmenu();">
                    <i class="fa fa-plus"></i> เพิ่มระบบไฟล์ Download
                </button>

            <?php } ?>
        </h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <?php
            foreach ($menu_admin->result() as $rss):
                if ($rss->typelink == '1') {
                    ?>
                    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3" style=" margin-bottom: 10px;">
                        <?php if ($this->session->userdata('status') == 'S') { ?>
                            <button type="button" class="btn btn-default" onclick="delete_admin_menu('<?php echo $rss->admin_menu_id ?>')"><i class="fa fa-trash text-danger"></i></button>
                        <?php } ?>

                        <a href="<?= site_url($rss->admin_menu_link) . '/' . $rss->admin_menu_id . '/' . $rss->admin_menu_name ?>" style=" text-decoration: none;">
                            <div class="btn btn-default btn-block" style=" text-align: center;">
                                <center>
                                    <div style="height:80px;">
                                        <img src="<?= base_url() ?>icon_menu/<?= $rss->admin_menu_images ?>" class="img-responsive" style="max-height: 80px;"/>
                                    </div>
                                    <br/><?= $rss->admin_menu_name ?>
                                </center>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            <?php endforeach; ?>
        </div>
    </div><!-- End Panel-Body-->
</div><!--./End Panel -->




<!---
########## Insert Update Delete #############
--->
<!-- Modal Add Menu Admin-->
<div id="AddMenu" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="DelImg();">×</button>
                <h4 id="myModalLabel">เพิ่มระบบงานไฟล์ Download</h4>
            </div>
            <div class="modal-body">
                <label>ชื่อ</label>
                <input type="text" id="admin_menu_name" style=" width: 95%;" class=" form-control"/>

                <input type="hidden" id="admin_menu_link" value="backend/pages/getpage" readonly style=" width: 95%;" class=" form-control"/>
                <label>รูปภาพระบบงาน</label>
                <div id="ShowImg">
                    <form>
                        <input id="file_upload" name="file_upload" type="file"/>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="SaveMenu();"><i class="fa fa-save"></i> บันทึกข้อมูล</button>
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
</script>
