<style type="text/css">
    .row{
        margin-top: 10px;
    }
</style>
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array("label" => "กระดานสนทนา","url" => "asbforum/backend/index")
);
$active = $head;

?>

<?php echo $model->breadcrumb_backend($list, $active); ?>

        <h3 id="head_submenu">
            <i class="fa fa-file-text-o fa-2x text-warning"></i>
            <?php
            echo $head;
            ?>
        </h3>
    
<hr id="hr"/>
<div id="asb-register">
    <div class="alert alert-warning">
        *เป็นการตั้งค่าเมื่อผู้ใช้งานสมัคสมาชิกเข้าใช้ระบบกระดานสนทนา ระบบจะทำการส่งอีเมล์ไปยังสมาชิกเพื่อให้ทำการยืนยันตัวตนก่อนใช้งาน
    </div>
    <div class="row">
        <div class="col-md-3 col-lg-3">TITLE : </div>
        <div class="col-md-5 col-lg-5">
            <input type="text" class="form-control" id="title" value="<?php echo $config->title ?>" placeholder="หัวข้อที่ใช้ส่งไปยังผู้รับ..."/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-lg-3">SMTP Server : </div>
        <div class="col-md-5 col-lg-5">
            <input type="text" class="form-control" id="smtp_server" value="<?php echo $config->smtp_server ?>" placeholder="smtp ที่ได้จากผู้ให้บริการเว็บโฮส์ตติ้ง..."/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-lg-3">SMTP Username : </div>
        <div class="col-md-3 col-lg-3">
            <input type="text" class="form-control" value="<?php echo $config->smtp_username ?>" id="smtp_username" placeholder="Username..."/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-lg-3">SMTP Password : </div>
        <div class="col-md-3 col-lg-3">
            <input type="text" class="form-control" id="smtp_password" value="<?php echo $config->smtp_password ?>" placeholder="Password..."/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-lg-3">PORT : </div>
        <div class="col-md-3 col-lg-3">
            <input type="text" class="form-control" id="port" placeholder="Default 25" value="<?php echo $config->port ?>"/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-lg-3">EMAIL Send : </div>
        <div class="col-md-3 col-lg-3">
            <input type="text" class="form-control" id="email_send" value="<?php echo $config->email_send ?>" placeholder="อีเมล์จากระบบหรือผู้ส่ง..."/>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-lg-3">NAME Send : </div>
        <div class="col-md-3 col-lg-3">
            <input type="text" class="form-control" id="name_send" value="<?php echo $config->name_send ?>" placeholder="ชื่อระบบหรือชื่อผู้ส่ง..."/>
        </div>
    </div>
</div>
<hr/>

<div class="row" style=" text-align: center;">
    <button type="button" class="btn btn-success" onclick="Save()"><i class="fa fa-save"></i> Save</button>
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
        var url = "<?php echo site_url('asbforum/config/saveconfig') ?>";
        //var emailFilter = /^.+@.+\..{2,3}$/;
        var id = "<?php echo $id ?>";
        var title = $("#title").val();
        var smtp_server = $("#smtp_server").val();
        var smtp_username = $("#smtp_username").val();
        var smtp_password = $("#smtp_password").val();
        var port = $("#port").val();
        var email_send = $("#email_send").val();
        var name_send = $("#name_send").val();
        
        if(title == ""){
            $("#title").focus();
            return false;
        }
        
        if (smtp_server == "") {
            $("#smtp_server").focus();
            return false;
        }
        if (smtp_username == "") {
            $("#smtp_username").focus();
            return false;
        }

        if(smtp_password == ""){
            $("#smtp_password").focus();
            return false;
        }
        
        if (port == "") {
            $("#port").focus();
            return false;
        }

        if (email_send == "") {
            $("#email_send").focus();
            return false;
        }

        if (name_send == "") {
            $("#name_send").focus();
            return false;
        }
        
        var data = {
                id: id,
                title: title,
                smtp_server: smtp_server,
                smtp_username: smtp_username,
                smtp_password: smtp_password,
                port: port,
                email_send: email_send,
                name_send: name_send
            };
        
        $.post(url,data,function(datas){
            window.location.reload();
        });

    }
</script>