<style type="text/css">
    .row{
        margin-bottom: 10px;
    }
    h4{
        color: #00cc99;
    }
</style>
<script src="<?php echo base_url() ?>assets/module/toberegis/js/app.js"></script>

<div style=" clear: both;">
    <input type="hidden" name="" id="urllogin" value="<?php echo site_url('toberegis/users/checklogin') ?>"/>
    <input type="hidden" name="" id="urlredir" value="<?php echo site_url('toberegis/users/detailuser') ?>"/>
    <h3><i class="fa fa-lock"></i> เข้าสู่ระบบ</h3>
    <hr/>
</div>
<div class="row">
    <div class="col-md-2 col-lg-2"><label>Username *</label></div>
    <div class="col-md-5 col-lg-4">
        <input type="text" name="username" id="username" class="form-control" placeholder="Username...">
    </div>
    <div class="col-md-5 col-lg-4">
        <div id="usernull" style=" text-align: left; color: #ff3300;"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-2 col-lg-2"><label>Password *</label></div>
    <div class="col-md-5 col-lg-4">
        <input type="password" name="password" id="password" class="form-control" placeholder="Password...">
    </div>
</div>

<hr/>
<div class="row">
    <div class="col-md-2 col-lg-2"></div>
    <div class="col-md-10 col-lg-10">
        <button type="button" class="btn btn-success" onclick="login()"><i class="fa fa-key"></i> Login</button>
    </div>
</div>
<div class="row">
    <div class="col-md-2 col-lg-2"></div>
    <div class="col-md-10 col-lg-10">
        <div id="error" style="color:red;"></div>
    </div>
</div>



