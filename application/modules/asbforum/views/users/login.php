<style type="text/css">
    .row{
        margin-bottom: 10px;
    }
</style>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = "";
$active = $head;

?>

<?php echo $model->breadcrumb($list, $active); ?>

<h3 id="head_submenu">
    <i class="fa fa-file-text-o fa-2x text-warning"></i>
    <?php
    echo $head;
    ?>
</h3>
<hr id="hr"/>
<div class="row">
    <div class="col-md-12 col-lg-6">

        <div class="row">
            <div class="col-lg-3" style=" text-align: right;">* Email : </div>
            <div class="col-lg-9">
                <input type="email" class=" form-control" id="email"/>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3" style=" text-align: right;">* Password : </div>
            <div class="col-lg-9">
                <input type="password" class=" form-control" id="password"/>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-md-9 col-lg-9">
                <label>พิมพ์ตัวอักษรที่เห็นในรูปด้านล่าง</label>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-md-6 col-lg-6">
                <div id="getcaptcha"></div>
            </div>
            <div class="col-md-2 col-lg-2" style=" padding-top: 15px;">
                <a href="javascript:Getcaptcha()"><i class="fa fa-refresh"></i></a></button>
            </div>
        </div>
        <div class="row" style=" margin-top: 10px;">
            <div class="col-lg-3"></div>
            <div class="col-md-6 col-lg-6">
                <input type="text" name="captcha" id="captcha" value="" class="form-control"/>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-9"><hr/></div>
        </div>
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-4">
                <button type="button" class="btn btn-success btn-sm btn-block" onclick="Login()">ลงชื่อเข้าใช้งาน</button>
            </div>
        </div>

    </div>
    <div class="col-md-12 col-lg-6" style=" text-align: center; padding-top: 50px;">
        <img src="<?php echo base_url() ?>assets/module/asbforum/images/system-login-icon.png" style="width:64px;"/>
        <br/><br/>ต้องการเป็นสมาชิกเข้าใช้งานกระดานสนทนา<br/><br/>
        <a href="<?php echo site_url('asbforum/users/register') ?>">
            <button type="button" class="btn btn-info btn-sm">สมัคสมาชิก</button></a>
    </div>
</div>

<script type="text/javascript">
    Getcaptcha();
    function Getcaptcha() {
        var url = "<?php echo site_url('asbforum/users/SetCaptcha') ?>";
        var data = {};
        $.post(url, data, function (datas) {
            $("#getcaptcha").html(datas);
        });
    }
</script>

<script type="text/javascript">
    function Login() {
        var url = "<?php echo site_url('asbforum/users/checkloginforum') ?>";
        var email = $("#email").val();
        var password = $("#password").val();
        var captcha = $("#captcha").val();
        var recaptcha = $("#recaptcha").val();
        var emailFilter = /^.+@.+\..{2,3}$/;

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
        if (captcha != recaptcha) {
            alert("กรอกรหัสภาพไม่ถูกต้อง");
            return false;
        }

        var Pass = (MD5(password));
        var data = {email: email, password: Pass};
        $.post(url, data, function (datas) {
            if (datas == "1") {
                var urlRedir = "<?php echo site_url('asbforum') ?>";
                window.location = urlRedir;
            } else if (datas == "2") {
                alert("ขออภัยผู้ใช้รายนี้ยังไม่ได้ยืนยันตัวตนกรุณาตรวจสอบที่อีเมล์ที่ใช้สมัค");
                window.location.reload();
            } else {
                alert("ขออภัยไม่มีรายชื่อในระบบ");
                window.location.reload();
            }
        });
    }
</script>


