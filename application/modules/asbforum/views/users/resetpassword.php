<style type="text/css">
    .row{
        margin-bottom: 10px;
    }
</style>
<script type="text/javascript">
    Getimgprofile('<?php echo $user->token_key ?>');
    function Getimgprofile(token) {
        var url = "<?php echo site_url('asbforum/users/getimgprofile') ?>";
        var data = {token: token};
        $.post(url, data, function (datas) {
            $("#profile-photo").html(datas);
        });
    }
</script>
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = "";
$active = $head;
?>
<?php echo $model->breadcrumb_backend($list, $active, "asbforum"); ?>

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

        Username : <?php echo $user->username ?><br/>
        <br/>
    </div>
    <div class="col-md-9 col-lg-9">
        ชื่อ - สกุล : 
        <?php
        $namelong = $user->name . "-" . $user->lname;
        if (!empty($namelong))
            echo $namelong;
        ?><br/>
        นามแฝง : <?php echo $user->alias ?><br/>
        อีเมล์ : <?php echo $user->email ?><br/>
        เบอร์โทรศัพท์ <?php
        if (!empty($user->tel))
            echo $user->tel;
        else
            echo "-";
        ?>
        <hr/>
        วันที่ลงทะเบียน : <?php echo $user->register_date ?><br/>
        แก้ไขล่าสุด : <?php echo $user->register_update ?><br/>
        <hr/>
        <h4>แก้ไขรหัสผ่าน</h4>
        <hr/>
        <div class="row">
            <div class="col-md-3 col-lg-3">รหัสผ่านปัจจุบัน</div>
            <div class="col-md-3 col-lg-3">
                <input type="password" id="password" class="form-control"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-lg-3">รหัสผ่านใหม่</div>
            <div class="col-md-3 col-lg-3">
                <input type="password" id="newpassword" class="form-control"/>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-3 col-lg-3"></div>
            <div class="col-md-3 col-lg-3">
                <button type="button" class="btn btn-default" onclick="resetpassword()">แก้ไขรหัสผ่าน</button>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    function checkemail(str) {
        var emailFilter = /^.+@.+\..{2,3}$/;
        if (!(emailFilter.test(str))) {
            alert("ท่านใส่อีเมล์ไม่ถูกต้อง");
            return false;
        }
        return true;
    }

    function resetpassword() {
        var url = "<?php echo site_url('asbforum/users/saveresetpassword') ?>";
        var token = "<?php echo $user->token_key ?>";
        var password = $("#password").val();
        var newpassword = $("#newpassword").val();

        if (password == "") {
            $("#password").focus();
            return false;
        }

        if (newpassword == "") {
            $("#newpassword").focus();
            return false;
        }
        var passwords = MD5(password);
        var data = {token: token, password: passwords, newpassword: newpassword};

        $.post(url, data, function (datas) {
            if (datas != "1") {
                //alert("ระบบลงทะเบียนสมาชิกให้ท่านแล้วกรุณายืนยันตัวตนที่ Email ของท่านที่ใช้สมัค");
                //swal("Success!", "ระบบลงทะเบียนสมาชิกให้ท่านแล้วกรุณายืนยันตัวตนที่ Email ของท่านที่ใช้สมัค ไม่พบอีเมล์ในกล่องให้ท่านเช็คที่ อีเมล์ขยะ", "success");
                swal({
                    title: "Success",
                    text: "รหัสผ่านของท่านถูกรีเซ็ตแล้ว ... กรุณาเข้าสู้ระบบใหม่",
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
                                window.location = "<?php echo site_url('asbforum/users/logout') ?>";
                            }
                        });

            } else {
                //alert("Email นี้ได้ลงทะเบียนเข้าใช้งานแล้ว ...!");
                //swal("Alert!", "Email นี้ได้ลงทะเบียนเข้าใช้งานแล้ว ...!", "warning");
                swal({
                    title: "Alert",
                    text: "รหัสผ่านไม่ถูกต้อง ...!",
                    type: "warning",
                    //showCancelButton: false,
                    //confirmButtonColor: "#DD6B55",
                    //confirmButtonText: "OK!",
                    cancelButtonText: "OK",
                    closeOnConfirm: true,
                    //closeOnCancel: false
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                window.location.reload();
                            }
                        });
            }
        });

    }
</script>
