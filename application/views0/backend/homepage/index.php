<style type="text/css">
    .list-group-item {
        word-wrap: break-word;
    }

</style>
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$homepage = new homepage_model();
$sub_homepage = new sub_homepage_model();

$permission_homepage = $this->user->get_permission_user($this->session->userdata('user_id'));

$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
        //array('url' => '', 'label' => 'menu2')
);

$active = $head;
//$list = "";
echo $model->breadcrumb_backend($list, $active);
?>
<h3><i class="fa fa-newspaper-o"></i> <?php echo $head ?></h3>
<hr/>

<?php if (!empty($mas_homepage)) { ?>
    <?php if ($this->session->userdata('status') == 'S') { ?>
        <button type="button" class="btn btn-default" onclick="popup_create()">
            <i class="fa fa-plus-circle fa-2x text-success"></i><br/>
            เพิ่มเรื่องในหน้าเว็บ
        </button>

        <button type="button" class="btn btn-default" onclick="sort_order()">
            <i class="fa fa-long-arrow-up fa-2x text-success"></i>
            <i class="fa fa-long-arrow-down fa-2x text-warning"></i>
            <br/>
            จัดลำดับการแสดง
        </button>
    <?php } ?>
    <br/><br/>
    <div class="row">
        <?php foreach ($mas_homepage->result() as $rs): ?>
            <div class="<?php echo $rs->style ?>">
                <div class="well well-sm" style="background:<?php echo $rs->box_color ?>; padding-bottom:30px; border:0px; box-shadow:none;">
                    <h3 style=" margin-bottom: 0px; color:<?php echo $rs->head_color ?>;">
                        <?php echo $rs->title_name ?>

                        <?php if (in_array($rs->id, $permission_homepage) || $this->session->userdata('status') == 'S') { ?>
                            <!--
                                <a href="<?//php echo site_url('backend/sub_homepage/create_subhomepage/' . $rs->id) ?>" title="เพิ่ม">
                            -->
                            <button type="button" class="btn btn-default"
                                    onclick="popuptypemenu('<?php echo $rs->id ?>')"><i class="fa fa-plus-circle text-success"></i></button>
                            <!--
                            </a>
                            -->
                        <?php } else { ?>
                            <font style="color:red;">(คุณไม่มีสิทธิ์ในเมนูนี้ ... )</font>
                        <?php } ?>

                        <?php if ($this->session->userdata('status') == 'S') { ?>
                            <a href="javascript:popup_edit('<?php echo $rs->id ?>')" title="แก้ไข">
                                <button type="button" class="btn btn-default"><i class="fa fa-pencil text-warning"></i></button></a>
                            <a href="javascript:delete_homepage('<?php echo $rs->id ?>')" title="ลบ">
                                <button type="button" class="btn btn-default"><i class="fa fa-trash text-danger"></i></button></a>
                        <?php } ?>
                    </h3>

                    <hr style="border:<?php echo $rs->head_color ?> solid 2px; margin-top: 5px; margin-bottom: 5px;"/>

                    <ul class="list-group">
                        <?php
                        $subhomepage = $sub_homepage->get_subhomepage($rs->id, $rs->limit);
                        foreach ($subhomepage->result() as $sm):
                            $users = $this->user->view($sm->owner);
                            ?>
                            <li class="list-group-item">
                                <font style="color:red;">
                                <i class="fa fa-calendar"></i>
                                <?php echo $model->thaidate($sm->create_date) ?>
                                </font>
                                <?php if ($sm->final == 0) { ?>
                                    <a href="<?php echo site_url('backend/sub_homepage/viewpper/' . $sm->id . "/" . $rs->id) ?>">
                                        <?php echo $sm->title ?>
                                        <i class="fa fa-angle-right text-warning"></i>
                                    </a>
                                <?php } else { ?>
                                    <?php echo $sm->title ?><em style=" color: #999999;">(โดย : <?php echo $users->name . ' ' . $users->lname ?>)</em>
                                <?php } ?>
                                <div class="pull-right">
                                    <?php if ($sm->final == 1) { ?>
                                        <a href="<?php echo site_url('backend/sub_homepage/view/' . $sm->id) ?>">
                                            <button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></button></a>
                                    <?php } ?>
                                    <?php if ($sm->owner == $this->session->userdata('user_id') || $this->session->userdata('status') == 'S') { ?>
                                        <?php if ($sm->final == 0) { ?>
                                            <a href="<?php echo site_url('backend/sub_homepage/update/' . $sm->id . '/' . true) ?>">
                                                <button type="button" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></button></a>
                                        <?php } else { ?>
                                            <a href="<?php echo site_url('backend/sub_homepage/update/' . $sm->id) ?>">
                                                <button type="button" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></button></a>
                                        <?php } ?>
                                        <button type="button" class="btn btn-danger btn-xs" onclick="delete_subhomepage('<?php echo $sm->id ?>')"><i class="fa fa-trash-o"></i></button>
                                    <?php } ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                        <?php if ($subhomepage) { ?>
                            <a href="<?php echo site_url('backend/sub_homepage/all/' . $rs->id) ?>">
                                <button type="button" class="btn btn-default pull-right"
                                        style="margin-top: 5px;
                                        background:<?php echo $rs->head_color ?>;
                                        color:<?php echo $rs->box_color; ?>">ทั้งหมด ...</button></a>
                                    <?php } ?>
                    </ul>
                </div><!-- End Color -->
            </div><!-- End Box -->
        <?php endforeach; ?>
    </div><!-- End Row -->
<?php } else { ?>
    <center>
        <br/>
        <h4>ยังไม่มีข้อมูล ...</h4><br/>
        <button type="button" class="btn btn-default" onclick="popup_create()">
            <i class="fa fa-plus-circle fa-2x text-success"></i><br/>
            เพิ่มเนื้อหาหน้าเว็บ
        </button>
    </center>
    <br/>
<?php } ?>


<!--
    ###### Insert MasHomePage ######
-->

<div class="modal fade" tabindex="-1" role="dialog" id="popup_create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus text-success"></i> เพิ่มเรื่องในหน้าเว็บ</h4>
            </div>
            <div class="modal-body">
                <label>เรื่อง</label>
                <input type="text" class="form-control" id="title_name"/>
                <label>จำนวนที่ให้แสดง</label>
                <input type="number" id="limit" value="5" class="form-control"/>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <br/>
                        <label>สีพื้นหลัง</label>
                        <input type="color" id="box_color" value="#FFFFFF"/>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <br/>
                        <label>สีข้อความหัวเรื่อง</label>
                        <input type="color" id="head_color" value="#999999"/>
                    </div>
                </div>
                <label>รูปแบบ</label>
                <select id="type_id" class="form-control" onchange="get_style(this.value)">
                    <option value="">== เลือกรูปแบบ ==</option>
                    <?php foreach ($type->result() as $t): ?>
                        <option value="<?php echo $t->id ?>"><?php echo $t->type_menu ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="row" style=" padding:0px;">
                    <br/>
                    <center>ตัวอย่าง</center><br/>
                    <div class="col-sm-12 col-md-12 col-lg-12" id="full" style="height: 100px; display: none;">
                        <div class="panel panel-default">
                            <div class="panel-heading">เรื่อง</div>
                            <div class="panel-body">
                                ข้อมูล
                            </div>
                        </div>
                    </div>
                    <div id="half" style="display: none;">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="height: 100px;">
                            <div class="panel panel-default">
                                <div class="panel-heading">เรื่อง</div>
                                <div class="panel-body">ข้อมูล</div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="height: 100px;">
                            <div class="panel panel-default">
                                <div class="panel-heading">เรื่อง</div>
                                <div class="panel-body">ข้อมูล</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="create_homepage()">บันทึก</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--
###### Dialog Edit ######
-->
<div class="modal fade" tabindex="-1" role="dialog" id="popup_edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-pencil text-success"></i>แก้ไขเรื่องในหน้าเว็บ</h4>
            </div>
            <div class="modal-body" id="update_homepage"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="save_update_homepage()">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<!--
###### Dialog SortOrder ######
-->
<div class="modal fade" tabindex="-1" role="dialog" id="popup_sort_order">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <i class="fa fa-long-arrow-up fa-2x text-success"></i>
                    <i class="fa fa-long-arrow-down fa-2x text-warning"></i>
                    จัดลำดับการแสดง</h4>
            </div>
            <div class="modal-body" id="sort_order"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="save_sort_order()">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<!--
############# DialogSelectTypeSubmenu ###############
-->

<div class="modal fade fade bs-example-modal-sm" tabindex="-1" role="dialog" id="popup_type_menu">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <i class="fa fa-bars fa-2x text-success"></i>
                    ประเภทเมนู</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="idmenu"/>
                    <div class="col-md-6 col-lg-6">
                        <button type="button" class="btn btn-default btn-block"
                                onclick="linkcreate()">
                            <i class="fa fa-file-text-o"></i> เพิ่มเนื้อหา</button>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <button type="button" class="btn btn-default btn-block"
                                onclick="popupcreateupperlever()">
                            <i class="fa fa-list"></i> มีเมนูย่อย</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>


<!-- dialogcreateUpper -->

<div class="modal fade fade bs-example-modal-lg" tabindex="-1" role="dialog" id="popupupper">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <i class="fa fa-bars fa-2x text-success"></i>
                    หัวข้อ</h4>
            </div>
            <div class="modal-body">
                <label>หัวข้อเมนู</label>
                <input type="text" class=" form-control" id="Smenu"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-default"
                        onclick="saveupperlevel()">บันทึกข้อมูล</button>
            </div>
        </div>
    </div>
</div>


<!-- Script -->
<script type="text/javascript">
    function popup_create() {
        $("#popup_create").modal();
    }

    function popup_edit(Id) {
        $("#popup_edit").modal();
        var url = "<?php echo site_url('backend/homepage/update') ?>";
        var data = {id: Id};
        $.post(url, data, function (datas) {
            $("#update_homepage").html(datas);
        });

    }

    function create_homepage() {
        var url = "<?php echo site_url('backend/homepage/save') ?>";
        var owner = "<?php echo $this->session->userdata('user_id') ?>";
        var title_name = $("#title_name").val();
        var type_id = $("#type_id").val();
        var limit = $("#limit").val();
        var box_color = $("#box_color").val();
        var head_color = $("#head_color").val();
        var data = {
            owner: owner,
            title_name: title_name,
            type_id: type_id,
            limit: limit,
            box_color: box_color,
            head_color: head_color
        };
        if (title_name == '') {
            $("#title_name").focus();
            return false;
        }

        if (type_id == '') {
            alert("ยังไม่ได้เลือกรูปแบบ")
            return false;
        }

        $.post(url, data, function (success) {
            window.location.reload();
        });
    }

    function get_style(id) {
        if (id == '1') {
            $("#full").show();
            $("#half").hide();
        } else if (id == '2') {
            $("#half").show();
            $("#full").hide();
        } else {
            $("#half").hide();
            $("#full").hide();
        }
    }
</script>

<script type="text/javascript">
    function delete_subhomepage(Id) {
        var r = confirm("คุณต้องการลบข้อมูลใช่ หรือ ไม่ ...?");
        if (r == true) {
            var url = "<?php echo site_url('backend/sub_homepage/delete') ?>";
            var data = {id: Id};

            $.post(url, data, function (success) {
                window.location.reload();
            });
        }
    }

    function delete_homepage(Id) {
        var r = confirm("คุณต้องการลบข้อมูลใช่ หรือ ไม่ ...?");
        if (r == true) {
            var url = "<?php echo site_url('backend/homepage/delete') ?>";
            var data = {id: Id};

            $.post(url, data, function (success) {
                window.location.reload();
            });
        }
    }

    function sort_order() {
        $("#popup_sort_order").modal();
        var url = "<?php echo site_url('backend/homepage/all') ?>";
        var data = {a: 1};
        $.post(url, data, function (html) {
            $("#sort_order").html(html);
        });
    }


    function popuptypemenu(homepageID) {
        $("#idmenu").val(homepageID);
        $("#popup_type_menu").modal();
    }

    function linkcreate() {
        var id = $("#idmenu").val();
        var url = "<?php echo site_url('backend/sub_homepage/create_subhomepage/') ?>" + "/" + id;
        window.location = url;
    }

    function popupcreateupperlever() {
        $("#popup_type_menu").modal("hide");
        $("#popupupper").modal();
    }

    function saveupperlevel() {
        var url = "<?php echo site_url('backend/sub_homepage/create_subhomepage_upper') ?>";
        var id = $("#idmenu").val();
        var title = $("#Smenu").val();
        var data = {homepage_id: id, title: title};
        if (title == '') {
            $("#Smenu").focus();
            return false;
        }
        $.post(url, data, function (datas) {
            var id = datas.id;
            var homepage_id = datas.homepage_id;
            var urllink = "<?php echo site_url('backend/sub_homepage/viewpper/') ?>" + "/" + id + "/" + homepage_id;
            window.location = urllink;
        }, "json");
    }
</script>
