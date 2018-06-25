<style type="text/css">
    #body-user .panel{
        background: none;
        border: none;
    }

    #body-user .panel-heading{
        background: none;
    }

</style>
<script type="text/javascript">
    get_photo();
    $(document).ready(function () {

        $("#add_new").click(function () {
            $("#box_insert_new").show();
        });
        $('#file_upload').uploadify({
            'buttonText': 'เลือกรูปภาพ ...',
            'auto': true, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('backend/users/upload_images') ?>' + "/<?php echo $user->user_id ?>", //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
            'fileSizeLimit': '2MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
            /*
             'width': '350',
             'height': '40',
             */
            'fileTypeExts': '*.gif; *.jpg; *.png; *.JPG;', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
            'multi': true, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
            'queueSizeLimit': 1, //อัพโหลดได้ครั้งละ 5 ไฟล์
            'onUploadComplete': function (success) { //เมื่ออัพโหลดเสร็จแล้วให้เรียกใช้งาน function load()
                get_photo();
            }
        });
    });

    function get_photo() {
        var url = "<?php echo site_url('backend/users/getphoto') ?>";
        var user_id = "<?php echo $user->user_id; ?>";
        var data = {user_id: user_id};
        $.post(url, data, function (datas) {
            $("#photo").html(datas);
        });
    }
</script>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#tb_mas_menu,#tb_permission_homepage,#tb_permission_module').dataTable({
            //"sPaginationType" : "full_numbers",// แสดงตัวแบ่งหน้า
            //"bLengthChange": false, // แสดงจำนวน record ที่จะแสดงในตาราง
            //"iDisplayLength": 20, // กำหนดค่า default ของจำนวน record
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
            },
            "scrollY": "200px",
            "scrollCollapse": true,
            "paging": false
        });
    });
</script>

<script type="text/javascript">
    function check_false(user_id, admin_menu_id) {
        var url = "<?= site_url('backend/users/add_permissions/') ?>";
        var data = {
            user_id: user_id,
            admin_menu_id: admin_menu_id
        };
        $.post(url, data, function (success) {
            window.location.reload();
        }
        );// Endpost
    }
</script>

<script type="text/javascript">
    function check_true(id) {
        var url = "<?= site_url('backend/users/del_permissions/') ?>";
        var data = {id: id};
        $.post(url, data, function (success) {
            window.location.reload();
        }
        );// Endpost
    }
</script>

<script type="text/javascript">

    function edit_user() {
        var url = "<?= site_url('backend/users/edit_user') ?>";
        var emailFilter = /^.+@.+\..{2,3}$/;
        var user_id = $("#user_id").val();
        var username = $("#username").val();
        var password = $("#password").val();
        var name = $("#name").val();
        var lname = $("#lname").val();
        var email = $("#email").val();
        var card = $("#card").val();

        if (email != "") {
            if (!(emailFilter.test(email))) {
                alert("ท่านใส่อีเมล์ไม่ถูกต้อง");
                return false;
            }
        }

        if (username == "" || name == "" || lname == "") {
            alert("กรอกข้อมูลสำคัญเครื่องหมาย * ");
            return false;
        }


        var data = {
            user_id: user_id,
            username: username,
            password: password,
            name: name,
            lname: lname,
            email: email,
            card: card
        };

        $.post(url, data, function (success) {
            window.location.reload();
        });
    }

</script>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
    array('url' => 'backend/users/show_user', 'label' => 'ผู้ใช้งาน')
);

$active = "แก้ไข";
echo $model->breadcrumb_backend($list, $active);
?>

<br/>
<!-- Dialog Insert News -->

<h3><i class="fa fa-user"></i> <?= $user->name . ' ' . $user->lname ?></h3>
<hr/>

<div id="body-user">
    <div class="row">
        <div class="col-md-4 col-lg-4">
            <div class="row">
                <div class="col-md-4 col-lg-4">
                    <div id="photo">
                        <img src="<?php echo base_url('images/user-icon.png') ?>"/>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6" style=" padding-top: 20px;">
                    <input id="file_upload" name="file_upload" type="file">
                    *ไฟล์ขนาดไม่เกิน 2 MB
                </div>
            </div>

            <br/>
            <label>*ชื่อ</label>
            <input type="hidden" value="<?php echo $user->user_id; ?>" id="user_id" name="user_id" class="form-control"/>
            <input type="text" id="name" name="name" style="width:98%;" required="required" value="<?= $user->name ?>" class="form-control"/>
            <label>*นามสกุล</label>
            <input type="text" id="lname" name="lname" style="width:98%;" required="required" value="<?= $user->lname ?>" class="form-control"/>
            <label>อีเมล์</label>
            <input type="email" id="email" name="email" style="width:98%;" required="required" value="<?= $user->email ?>" class="form-control"/>
            <label>บัตรประชาชน</label>
            <input type="text" id="card" name="card" style="width:98%;" required="required" value="<?= $user->card ?>" class="form-control" maxlength="13"/>

            <hr/>
            <div class="row">
                <div class="col-md-4 col-lg-4">
                    <label>*username</label>
                </div>
                <div class="col-md-8 col-lg-8">
                    <input type="text" id="username" name="username" style="width:98%;" required="required" value="<?= $user->username ?>" class="form-control"/>
                </div>
            </div>

            <div class="row" style=" margin-top: 10px;">
                <div class="col-md-4 col-lg-4">
                    <label>*password</label>
                </div>
                <div class="col-md-8 col-lg-8">
                    <input type="text" id="password" name="password" style="width:98%;"  class="form-control"/>
                </div>
            </div>

            <br/>
            <input type="button" class="btn btn-primary btn-block" value="แก้ไขข้อมูลผู้ใช้งาน" onclick="edit_user();"/>
        </div>
        <div class="col-md-8 col-lg-8">
            <?php if ($user->status != 'S') { ?>
                <div class="well">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-group"></i> สิทธิ์จัดการเว็บไซต์
                                </div>
                                <div class="panel-body" style=" height: 200px; overflow: auto;">
                                    <?php
                                    foreach ($menu_admin->result() as $rs):
                                        ?>
                                        <div style=" border-bottom: #cccccc dotted 1px;">
                                            <?php if ($rs->active == 1) { ?>
                                                <input type="checkbox" id="status_show"  checked="checked" onclick="return check_true('<?= $rs->id ?>');"/>
                                            <?php } else { ?>
                                                <input type="checkbox" id="status_noshow" onclick="return check_false('<?= $user->user_id ?>', '<?= $rs->admin_menu_id ?>');"/>
                                            <?php } ?>
                                            <?= $rs->admin_menu_name ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div> <!-- End Col -->

                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <!--
                              ######### สิทธิ์การใช้งาน เมนู Homepage ###########
                            -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-tasks"></i> สิทธิ์จัดการเมนูหน้าเว็บ
                                </div>
                                <div class="panel-body" style=" height: 200px; overflow: auto;">
                                    <?php foreach ($permission_homepage->result() as $per): ?>
                                        <div style=" border-bottom: #cccccc dotted 1px;">
                                            <?php if ($per->menu_active != '') { ?>
                                                <input type="checkbox" checked="checked" onclick="set_delete_homepage('<?php echo $per->permission_id ?>')"/>
                                            <?php } else { ?>
                                                <input type="checkbox" onclick="set_add_homepage('<?php echo $per->id ?>')"/>
                                            <?php } ?>
                                            <?php echo $per->title_name ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div> <!-- End Col -->

                    </div> <!-- End Row -->

                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <!--
                              ######### สิทธิ์การใช้งาน Module ###########
                            -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-plug"></i> สิทธิ์จัดการโมดูล
                                </div>
                                <div class="panel-body" style=" height: 200px; overflow: auto;">
                                    <?php
                                    foreach ($permission_module->result() as $module):
                                        ?>
                                        <div style=" border-bottom: #cccccc dotted 1px;">
                                            <?php if ($module->menu_active != '') { ?>
                                                <input type="checkbox" checked="checked" onclick="set_delete_module('<?php echo $module->permission_id ?>')"/>
                                            <?php } else { ?>
                                                <input type="checkbox" onclick="set_add_module('<?php echo $module->id ?>')"/>
                                            <?php } ?>
                                            <?php echo $module->thainame ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End Col -->
                </div>
            </div>
        <?php } ?>
    </div>
</div>



<script type="text/javascript">
    function set_add_homepage(homepage_id) {
        var url = "<?php echo site_url('backend/users/addpermission_homepage') ?>";
        var user_id = $("#user_id").val();
        var data = {
            user_id: user_id,
            homepage_id: homepage_id
        };

        $.post(url, data, function (success) {
            //swal("Success", "", "success");
            window.location.reload();
        });
    }

    function set_delete_homepage(id) {
        var url = "<?php echo site_url('backend/users/deletepermission_homepage') ?>";
        var data = {id: id};

        $.post(url, data, function (success) {
            //swal("Success", "", "success");
            window.location.reload();
        });
    }

    function set_add_module(module_id) {
        var url = "<?php echo site_url('backend/users/addpermission_module') ?>";
        var user_id = $("#user_id").val();
        var data = {
            user_id: user_id,
            module_id: module_id
        };

        $.post(url, data, function (success) {
            //swal("Success", "", "success");
            window.location.reload();
        });
    }

    function set_delete_module(id) {
        var url = "<?php echo site_url('backend/users/deletepermission_module') ?>";
        var data = {id: id};

        $.post(url, data, function (success) {
            //swal("Success", "", "success");
            window.location.reload();
        });
    }
</script>
