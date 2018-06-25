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
    function get_photo() {
        var url = "<?php echo site_url('backend/users/getphoto') ?>";
        var user_id = "<?php echo $user->user_id; ?>";
        var data = {user_id: user_id};
        $.post(url, data, function (datas) {
            $("#photo").html(datas);
        });
    }
</script>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = "";

$active = $head;
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
            </div>

            <br/>
            <label>ชื่อ</label>:<?= $user->name ?><br/>
            <label>นามสกุล</label>:<?= $user->lname ?><br/>
            <label>อีเมล์</label>:<?= $user->email ?><br/>
            <label>บัตรประชาชน</label>:<?= $user->card ?>

            <hr/>
            <div class="row">
                <div class="col-md-4 col-lg-4">
                    <label>username</label>
                </div>
                <div class="col-md-8 col-lg-8">
                    <?= $user->username ?>
                </div>
            </div>
            <hr/>
            Create: <?php echo $user->create_date ?><br/>
            Update: <?php echo $user->update_date ?>
        </div>
        <div class="col-md-8 col-lg-8">
            <div class="well">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-group"></i> สิทธิ์จัดการเว็บไซต์
                            </div>
                            <div class="panel-body">
                                <?php
                                foreach ($menu_admin->result() as $rs):
                                    if ($rs->active == 1) {
                                        ?>
                                        <div style=" border-bottom: #cccccc dotted 1px;">
                                            - <?= $rs->admin_menu_name ?>
                                        </div>
                                    <?php } ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div> <!-- End Col -->

                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <!--
                          ######### สิทธิ์การใช้งาน เมนู Homepage ###########
                        -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-tasks"></i> สิทธิ์จัดการเมนูหน้าเว็บ
                            </div>
                            <div class="panel-body">
                                <?php
                                foreach ($permission_homepage->result() as $per):
                                    if ($per->menu_active != '') {
                                        ?>
                                        <div style=" border-bottom: #cccccc dotted 1px;">
                                           - <?php echo $per->title_name ?>
                                        </div>
                                        <?php
                                    }
                                endforeach;
                                ?>
                            </div>
                        </div>
                    </div> <!-- End Col -->

                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <!--
                          ######### สิทธิ์การใช้งาน Module ###########
                        -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-plug"></i> สิทธิ์จัดการโมดูล
                            </div>
                            <div class="panel-body">
                                <?php
                                foreach ($permission_module->result() as $module):
                                    if ($module->menu_active != '') {
                                        ?>
                                        <div style=" border-bottom: #cccccc dotted 1px;">
                                            - <?php echo $module->thainame ?>
                                        </div>
                                    <?php } ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div> <!-- End Col -->
            </div>
        </div>
    </div>
</div>
