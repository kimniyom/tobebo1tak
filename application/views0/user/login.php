<meta charset="UTF-8"/>
<script src="<?php echo base_url() ?>js/jquery-1.11.3.min.js" type="text/javascript"></script>

<!-- Bootstrap 3-->
<link href="<?php echo base_url() ?>themes/2016/css/bootstrap-paper.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url() ?>themes/2016/js/bootstrap.js" type="text/javascript"></script>
<!--
<script src="<?//php echo base_url() ?>js/login.js" type="text/javascript"></script>
-->

<!-- Icon aware-some -->
<link href="<?php echo base_url() ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />

<!-- sweet-alert-->
<link href="<?php echo base_url() ?>assets/sweet-alert/sweetalert.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url() ?>assets/sweet-alert/sweetalert.min.js" type="text/javascript"></script>

<div class="container">
    <div class="modal fade" tabindex="-1" role="dialog" id="dialog-login" data-backdrop="static" style="margin-top:10%;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="box-shadow:none;">
                <div class="modal-header">
                    <h4 class="modal-title" style="text-align:center;"><i class="fa fa-group"></i> Admin login</h4>
                </div>
                <div class="modal-body">
                    
                        <div class="row">
                            <div class="col-md-2 col-lg-2">
                                <i class="fa fa-user" style="margin-top:10px;"></i>
                            </div>
                            <div class="col-md-10 col-lg-10">
                                    <input type="text" class="form-control" id="username" placeholder="Username">
                            </div>
                        </div>
                     
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-2 col-lg-2">
                                <i class="fa fa-key" style="margin-top:10px;"></i> 
                            </div>
                             <div class="col-md-10 col-lg-10">
                                    <input type="password" class="form-control" id="password" placeholder="Password">                                             
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-block" onclick="do_login()"><i class="fa fa-sign-in"></i> login</button>
                </div>
            </div><!-- /.modal-content -->
            <br/>
            <center>
                <font style=" font-size:12px;">
                &copy <?php echo date('Y') ?> The Assembler Themes.<br/>
                <a href="<?php echo site_url('') ?>"><i class="fa fa-home"></i> Home</a> | <a href="https://www.theassemblers.net" target="_blank">www.theassemblers.net</a>
                </font>
            </center>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<input type="hidden" id="base_url" value="<?php echo base_url(); ?>"/>
<input type="hidden" id="status" value="<?php echo $this->session->userdata('status'); ?>"/>
<script type="text/javascript">
    $(document).ready(function () {
        $("#dialog-login").modal();
    });

    check_user();
    function check_user() {
        var status = $("#status").val();
        if (status != '') {
            window.location = "<?php echo base_url('index.php/takmoph_admin') ?>";
        }
    }
    function do_login() {
        var base_url = $("#base_url").val();
        var url = base_url + "index.php/users/do_login";
        var username = $("#username").val();
        var password = $("#password").val();
        var data = {
            username: username,
            password: password
        };

        if (username == '' || password == '') {
            //alert("กรอกข้อมูลไม่ครบ");
            swal("Warning!", "กรอกข้อมูลไม่ครบ..!", "warning");
            return false;
        }

        $.post(url, data, function (success) {
            //alert(success);
            if (success == "Success") {
                window.location = base_url + "index.php/takmoph_admin";
            } else if (success == "NOSuccess") {
                swal("Warning!", "ไม่พบข้อมูล..!", "warning");
                window.location = base_url + "index.php/users/login";
            } else {
                window.location = base_url + "index.php/users/lock";
            }
        });
    }
</script>
