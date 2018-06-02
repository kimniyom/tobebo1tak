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
<div id="asb-register">
    <div class="row">
        <div class="col-md-3 col-lg-3">Email : </div>
        <div class="col-md-5 col-lg-5">
            <input type="email" class="form-control" id="email" placeholder="Email..."/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-lg-3">Username : </div>
        <div class="col-md-3 col-lg-3">
            <input type="text" class="form-control" id="username" placeholder="Username..."/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-lg-3">Password : </div>
        <div class="col-md-3 col-lg-3">
            <input type="password" class="form-control" id="password" placeholder="Password..."/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-lg-3">Confirm Password : </div>
        <div class="col-md-3 col-lg-3">
            <input type="password" class="form-control" id="repassword" placeholder="Confirm Password..."/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-lg-3">นามแฝง : </div>
        <div class="col-md-3 col-lg-3">
            <input type="text" class="form-control" id="alias" placeholder="alias..."/>
        </div>
    </div>
</div>
<hr/>
<h4>
    เงื่อนไขและข้อตกลงในการใช้งาน
</h4>
<ul>
    <?php foreach ($agreement->result() as $rs): ?>
        <li><?php echo $rs->agreement ?></li>
    <?php endforeach; ?>
</ul>
<center>
    <input type="checkbox" id="confirm"/> ยอมรับข้อตกลง
</center>
<hr/>
<div class="row" style=" text-align: center;" id="loading">
    <button type="button" class="btn btn-success" onclick="Save()">ลงทะเบียน</button>
</div>
<br/>

<script type="text/javascript">
    function checkemail(str) {
        var emailFilter = /^.+@.+\..{2,3}$/;
        if (!(emailFilter.test(str))) {
            alert("ท่านใส่อีเมล์ไม่ถูกต้อง");
            return false;
        }
        return true;
    }

    function Save() {
        
        var url = "<?php echo site_url('asbforum/users/saveregister') ?>";
        var emailFilter = /^.+@.+\..{2,3}$/;
        var email = $("#email").val();
        var username = $("#username").val();
        var password = $("#password").val();
        var repassword = $("#repassword").val();
        var alias = $("#alias").val();
        var confirm = $("#confirm").is(':checked') ? 1 : 0;
        
        if(email == ""){
            $("#email").focus();
            return false;
        }
        if (!(emailFilter.test(email))) {
            alert("ท่านใส่อีเมล์ไม่ถูกต้อง");
            return false;
        }
        
        if (username == "") {
            $("#username").focus();
            return false;
        }
        if (password == "") {
            $("#password").focus();
            return false;
        }
        if(password != repassword){
            alert("รหัสผ่านไม่ถูกต้อง");
            return false;
        }
        if(alias == ""){
            $("#alias").focus();
            return false;
        }
        
        if (confirm == 0) {
            alert("ท่านไม่ยอมรับข้อตกลง");
            return false;
        }
        
        
        
        var data = {email: email,username: username,password: password,alias: alias};
        
        $.post(url,data,function(datas){
            $("#loading").html("กำลังบันทึกข้อมูล...");
            if(datas != "1"){
                //alert("ระบบลงทะเบียนสมาชิกให้ท่านแล้วกรุณายืนยันตัวตนที่ Email ของท่านที่ใช้สมัค");
                //swal("Success!", "ระบบลงทะเบียนสมาชิกให้ท่านแล้วกรุณายืนยันตัวตนที่ Email ของท่านที่ใช้สมัค ไม่พบอีเมล์ในกล่องให้ท่านเช็คที่ อีเมล์ขยะ", "success");
                swal({
                    title: "Success",
                    text: "ระบบลงทะเบียนสมาชิกให้ท่านแล้วกรุณายืนยันตัวตนที่ Email ของท่านที่ใช้สมัค หากไม่พบอีเมล์ในกล่องให้ท่านเช็คที่ อีเมล์ขยะ",
                    type: "success",
                    //showCancelButton: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "OK",
                    //cancelButtonText: "No, cancel plx!",
                    //closeOnConfirm: false,
                    //closeOnCancel: false
                    },
                    function(isConfirm){
                    if (isConfirm) {
                        window.location="<?php echo site_url('asbforum/users/login')?>";
                    } 
                });
                
            } else {
                //alert("Email นี้ได้ลงทะเบียนเข้าใช้งานแล้ว ...!");
                //swal("Alert!", "Email นี้ได้ลงทะเบียนเข้าใช้งานแล้ว ...!", "warning");
                swal({
                    title: "Alert",
                    text: "Email นี้ได้ลงทะเบียนเข้าใช้งานแล้ว ...!",
                    type: "warning",
                    //showCancelButton: false,
                    //confirmButtonColor: "#DD6B55",
                    //confirmButtonText: "OK!",
                    cancelButtonText: "OK",
                    closeOnConfirm: true,
                    //closeOnCancel: false
                    },
                    function(isConfirm){
                    if (isConfirm) {
                        window.location.reload();
                    } 
                });
            }
        });

    }
</script>