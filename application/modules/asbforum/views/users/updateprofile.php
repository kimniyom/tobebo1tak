<script type="text/javascript">
    Getimgprofile('<?php echo $user->token_key ?>');
    $(document).ready(function () {
        var token = "<?php echo $user->token_key ?>";
        $('#file_upload').uploadify({
            'buttonText': 'กรุณาเลือกไฟล์ ...',
            'auto': true, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('asbforum/users/uploadphoto') ?>' + "/" + token, //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
            'fileSizeLimit': '1MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
            //'width': '350',
            //'height': '40',
            'fileTypeExts': '*.jpg; *.jpeg; *.JPG; *.JPEG; *.png;', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
            'multi': false, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
            'queueSizeLimit': 1, //อัพโหลดได้ครั้งละ 5 ไฟล์
            'onUploadComplete': function (success) { //เมื่ออัพโหลดเสร็จแล้วให้เรียกใช้งาน function load()
                Getimgprofile(token);
            }
        });
    });

    function Getimgprofile(token) {
        var url = "<?php echo site_url('asbforum/users/getimgprofile') ?>";
        var data = {token: token};
        $.post(url, data, function (datas) {
            $("#profile-photo").html(datas);
        });
    }
</script>

<style type="text/css">
    .row{
        margin-top: 10px;
    }
</style>
<!-- sweet-alert-->
<link href="<?php echo base_url() ?>assets/sweet-alert/sweetalert.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url() ?>assets/sweet-alert/sweetalert.min.js" type="text/javascript"></script>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array("label" => $user->alias,"url" => "asbforum/users/profile")
);
$active = $head;
?>

<?php echo $model->breadcrumb($list, $active); ?>
<div id="asb-register">
    <h3 id="head_submenu">
        <i class="fa fa-file-text-o fa-2x text-warning"></i>
        <?php
        echo $head;
        ?>
    </h3>
    <hr id="hr"/>
    <div class="row">
        <div class="col-md-3 col-lg-3">
            <div id="profile-photo"></div><br/>
            <label>แนบไฟล์ *.jpg; *.png;</label>
            <p>(Max-size: 1MB)</p>
            <input id="file_upload" name="file_upload" type="file" multiple>
            Username : <?php echo $user->username ?><br/>
            เข้าใช้งานล่าสุด : <?php echo $last_update ?><br/>
            ยืนยันตัวตน : 
            <?php
            if ($user->active == "Y")
                echo "<i class='fa fa-check text-success'></i>";
            else
                echo "<i class='fa fa-remove text-danger'></i>";
            ?><br/>
        </div>
        <div class="col-md-9 col-lg-9">
            <h4>ข้อมูลทั่วไป</h4>
            <hr/>
            <div class="row">
                <div class="col-md-3 col-lg-3">ชื่อ : </div>
                <div class="col-md-3 col-lg-3">
                    <input type="text" class="form-control" id="name" placeholder="..." value="<?php echo $user->name ?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-lg-3">นามสกุล : </div>
                <div class="col-md-3 col-lg-3">
                    <input type="text" class="form-control" id="lname" placeholder="..." value="<?php echo $user->lname ?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-lg-3">*Username : </div>
                <div class="col-md-3 col-lg-3">
                    <input type="text" class="form-control" id="username" placeholder="Username..." value="<?php echo $user->username ?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-lg-3">*นามแฝง : </div>
                <div class="col-md-3 col-lg-3">
                    <input type="text" class="form-control" id="alias" placeholder="alias..." value="<?php echo $user->alias ?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-lg-3">เบอร์โทรศัพท์ : </div>
                <div class="col-md-3 col-lg-3">
                    <input type="text" class="form-control" id="tel" placeholder="tel..." value="<?php echo $user->tel ?>"/>
                </div>
                <div class="col-md-3 col-lg-3" id="loading">
                    <button type="button" class="btn btn-default" onclick="save()">บันทึก</button>
                </div>
            </div>

            <h4>เปลี่ยนที่อยู่ email</h4>
            <hr/>
            <div class="row">
                <div class="col-md-3 col-lg-3">Email : </div>
                <div class="col-md-5 col-lg-5">
                    <input type="email" class="form-control" id="email" placeholder="Email..."/>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-lg-3">Password : </div>
                <div class="col-md-3 col-lg-3">
                    <input type="password" class="form-control" id="password" placeholder="Password..."/>
                </div>
                <div class="col-md-3 col-lg-3">
                    <button type="button" class="btn btn-default" onclick="resetemail()">ยืนยัน</button>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div id="error"></div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    function save() {
        $("#loading").html("กำลังบันทึกข้อมูล...");
        var url = "<?php echo site_url('asbforum/users/saveupdateprofile') ?>";
        //var emailFilter = /^.+@.+\..{2,3}$/;
        //var email = $("#email").val();
        var username = $("#username").val();
        var name = $("#name").val();
        var lname = $("#lname").val();
        var tel = $("#tel").val();
        var token = "<?php echo $user->token_key ?>";
        //var password = $("#password").val();
        //var repassword = $("#repassword").val();
        var alias = $("#alias").val();
        //var confirm = $("#confirm").is(':checked') ? 1 : 0;

        /*
         if (email == "") {
         $("#email").focus();
         return false;
         }
         if (!(emailFilter.test(email))) {
         alert("ท่านใส่อีเมล์ไม่ถูกต้อง");
         return false;
         }
         */
        if (username == "") {
            $("#username").focus();
            return false;
        }
        /*
         if (password == "") {
         $("#password").focus();
         return false;
         }
         if (password != repassword) {
         alert("รหัสผ่านไม่ถูกต้อง");
         return false;
         }
         */
        if (alias == "") {
            $("#alias").focus();
            return false;
        }

        var data = {token: token, name: name, username: username, lname: lname, alias: alias, tel: tel};

        $.post(url, data, function (datas) {
            swal({
                title: "Success",
                text: "แก้ไขข้อมูลของท่านแล้ว",
                type: "success",
                //showCancelButton: false,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "OK",
                //cancelButtonText: "No, cancel plx!",
                //closeOnConfirm: false,
                //closeOnCancel: false
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            window.location.reload();
                        }
                    });

        });

    }

    function resetemail() {
        var url = "<?php echo site_url('asbforum/users/updateemail') ?>";
        var emailFilter = /^.+@.+\..{2,3}$/;
        var email = $("#email").val();
        var token = "<?php echo $user->token_key ?>";
        var password = $("#password").val();
        var passwords = MD5(password);
        if (email == "") {
            $("#email").focus();
            return false;
        }
        if (!(emailFilter.test(email))) {
            alert("ท่านใส่อีเมล์ไม่ถูกต้อง");
            return false;
        }

        if (password == "") {
            $("#password").focus();
            return false;
        }

        var data = {token: token, email: email, password: passwords};

        $.post(url, data, function (datas) {
            if (datas == "0") {
                swal({
                    title: "Success",
                    text: "แก้ไขอีเมล์ของ่ทานแล้ว กรุณายืนยันที่อีเมล์ใหม่ของท่านเพื่อเข้าใช้งาน",
                    type: "success",
                    //showCancelButton: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "OK",
                    //cancelButtonText: "No, cancel plx!",
                    //closeOnConfirm: false,
                    //closeOnCancel: false
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                window.location="<?php echo site_url('asbforum/users/logout')?>";
                            }
                        });
            } else {
                $("#error").html("<p class='text-danger'>รหัสผ่านไม่ถูกต้อง</p>");
                return false;
            }
        });


    }
</script>