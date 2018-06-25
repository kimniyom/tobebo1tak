<!-- ScriptUpload By Uploadify -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#file_upload').uploadify({
            'buttonText': 'กรุณาเลือกรูปภาพ ...',
            'auto': true, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('backend/menubar/upload_logo/') ?>', //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
            'fileSizeLimit': '2MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
            //'width': '350',
            //'height': '40',
            'fileTypeExts': '*.gif; *.jpg; *.png; *.JPG;', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
            'multi': false, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
            'queueSizeLimit': 1, //อัพโหลดได้ครั้งละ 5 ไฟล์
            'onUploadComplete': function (success) { //เมื่ออัพโหลดเสร็จแล้วให้เรียกใช้งาน function load()
                window.location.reload();
            }
        });

        $('#colorSelector').ColorPicker({
            color: '<?php echo $style->color_navbar ?>',
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $('#colorSelector div').css('backgroundColor', '#' + hex);
                $("#color").val('#' + hex);
            }
        });

        $('#color_head_Selector').ColorPicker({
            color: '<?php echo $style->color_head ?>',
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $('#color_head_Selector div').css('backgroundColor', '#' + hex);
                $("#color_head").val('#' + hex);
            }
        });

        $('#color_text_Selector').ColorPicker({
            color: '<?php echo $style->color_text ?>',
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $('#color_text_Selector div').css('backgroundColor', '#' + hex);
                $("#color_text").val('#' + hex);
            }
        });

    });


</script>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$navbarModel = new menubar_model();
$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
        //array('url' => '', 'label' => 'menu2')
);

$active = $head;
?>

<style type="text/css">
    #nav-bar ul li a:active{ background: <?php echo $style->color_head ?>;}
    #nav-bar ul li a:after{ background: <?php echo $style->color_head ?>;}
    #nav-bar ul li a:hover{ background: <?php echo $style->color_head ?>;}
    #h-hover a:hover{background: #000000;}
    #nav-bar ul li a:focus{ background: <?php echo $style->color_head ?>;}
</style>

<div class="row" style=" margin: 0px; padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 0px;">
        <h3 id="head_submenu"><i class="fa fa-magic"></i> <?php echo $head ?></h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-right: 0px;">
        <?php echo $model->breadcrumb_backend($list, $active); ?>
    </div>
</div>

<hr id="hr"/>

<label>โลโก้</label><br/>
<img src="<?php echo base_url() ?>upload_images/logo/<?php echo $style->logo ?>" class="img-responsive" style="max-width:200px;"/>
<br/>
อัพโหลดได้ไม่เกินครั้งละ 2MB,<br/>
อัพโหลดได้ไม่เกินครั้งละ 1 ไฟล์
<br /><br />
<form>
    <div id="queue"></div>
    <div style="width:350px;">
        <input id="file_upload" name="file_upload" type="file" multiple>
    </div>
</form><br />


<label>ชื่อเว็บแบบสั้น</label>
<input type="text" class="form-control" id="web_name_short" value="<?php echo $style->webname_short ?>"/><br/>

<label>ชื่อเว็บแบบยาว</label>
<input type="text" class="form-control" id="web_name_full" value="<?php echo $style->webname_full ?>"/><br/>

<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <label>แม่แบบ</label>
        <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                <div class="btn" style="background: #18bc9c;" onclick="set_color('#18bc9c', '#FFFFFF', '#15a589')"></div><!-- เขียวอ่อน -->
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                <div class="btn" style="background: #cc0000;" onclick="set_color('#cc0000', '#FFFFFF', '#990000')"></div><!-- แดง -->
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                <div class="btn" style="background: #009999;" onclick="set_color('#009999', '#FFFFFF', '#0f8888')"></div><!-- เขียวแก่ -->
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                <div class="btn" style="background: #0066cc;" onclick="set_color('#0066cc', '#FFFFFF', '#1668ba')"></div><!-- ฟ้าเข้ม -->
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                <div class="btn" style="background: #f6f4f4;" onclick="set_color('#ffffff', '#000000', '#eeedec')"></div><!-- ขาว -->
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                <div class="btn" style="background: #000000;" onclick="set_color('#000000', '#FFFFFF', '#333333')"></div><!-- ดำ -->
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                <div class="btn" style="background: #ff6600;" onclick="set_color('#ff6600', '#FFFFFF', '#e85e02')"></div><!-- ส้ม -->
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                <div class="btn" style="background: #bf01b0;" onclick="set_color('#bf01b0', '#FFFFFF', '#d118c2')"></div><!-- ม่วง -->
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <label>กำหนดเอง</label>
        <div class="row">
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                <center>
                    <div id="colorSelector"><div style="background-color:<?php echo $style->color_navbar ?>;"></div></div>
                    Navbar
                </center>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                <center>
                    <div id="color_head_Selector"><div style="background-color:<?php echo $style->color_head ?>;"></div></div>
                    Menu
                </center>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                <center>
                    <div id="color_text_Selector"><div style="background-color:<?php echo $style->color_text ?>;"></div></div>
                    Text
                </center>
            </div>
        </div>
    </div>

</div><!-- End Rows -->

<input type="hidden" id="color" value="<?php echo $style->color_navbar ?>"/>
<input type="hidden" id="color_text" value="<?php echo $style->color_text ?>"/>
<input type="hidden" id="color_head" value="<?php echo $style->color_head ?>"/>

<nav class="navbar navbar-default" id="nav-bar"
     style="background: <?php echo $style->color_navbar ?>; color: <?php echo $style->color_text ?>;border-radius:0px; border:0px;">
    <div class="alert alert-success" style=" margin: 0px; border-radius: 0px; padding:5px 5px 5px 20px; border:0px; background:<?php echo $style->color_head ?>;">
        <div style="color: <?php echo $style->color_text ?>; margin:0px; ">
            <?php echo $style->webname_full ?>
        </div>
    </div>
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false" >
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#" style=" margin-top: 0px; padding-top: 5px;">
                <img src="<?php echo base_url() ?>upload_images/logo/<?php echo $style->logo ?>" style=" height: 42px;"/>
            </a>
            <a class="navbar-brand" href="#" style=" color: <?php echo $style->color_text ?>;"><?php echo $style->webname_short ?></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo site_url('') ?>" style=" color: <?php echo $style->color_text ?>;">หน้าแรก</a></li>
                <?php
                foreach ($navbar->result() as $nb):
                    ?>
                    <?php if ($nb->type == '0') { ?>
                        <li>
                            <a href="<?php echo site_url('backend/menubar/view/' . $nb->id) ?>"
                               style=" color: <?php echo $style->color_text ?>;">
                                <?php echo $nb->title ?></a>
                        </li>
                    <?php } else if ($nb->type == '2') { ?>
                        <li>
                            <a href="<?php echo site_url('backend/menubar/view/' . $nb->id) ?>"
                               style=" color: <?php echo $style->color_text ?>;">
                                <?php echo $nb->title ?> <i class="fa fa-link"></i></a>
                        </li>
                    <?php } else { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" style=" color: <?php echo $style->color_text ?>;"
                               data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <?php echo $nb->title ?> <span class="caret"></span>
                                <i class="fa fa-trash" onclick="delete_page('<?php echo $nb->id ?>')"></i>
                            </a>
                            <ul class="dropdown-menu" style=" background: <?php echo $style->color_navbar ?>;">

                                <!--
                                    ########## Subnavbar ###########
                                -->

                                <?php
                                $subnav = $navbarModel->get_sub_navbarmenu($nb->id);
                                foreach ($subnav->result() as $snSub):
                                    ?>

                                    <li>
                                        <a href="<?php echo site_url('backend/menubar/view/' . $snSub->id) ?>"
                                           style="color: <?php echo $style->color_text ?>;">
                                               <?php if ($snSub->type == '2') { ?>
                                                <i class="fa fa-link"></i>
                                                <?php echo $snSub->title ?>
                                            <?php } else { ?>
                                                <i class="fa fa-angle-right"></i>
                                                <?php echo $snSub->title ?>
                                            <?php } ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                                <li role="separator" class="divider"></li>
                                <li id="h-hover">
                                    <a href="javascript:popup_add_subnavbar('<?php echo $nb->id ?>')" style="color: <?php echo $style->color_text ?>;">
                                        <i class="fa fa-plus"></i>เพิ่มเมนูย่อย</a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                <?php endforeach; ?>

                <li>
                    <a href="javascript:popup_add_navbar()" style="color:<?php echo $style->color_text ?>;"><i class="fa fa-plus"></i> เพิ่ม</a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<hr/>

<button type="button" class="btn btn-default pull-right" onclick="save()">
    <i class="fa fa-save"></i> บันทึกการเปลี่ยนแปลง
</button>
<br/>

<!--
    ###### Add Navbar ######
-->
<div class="modal fade" tabindex="-1" role="dialog" id="dialog_add_navbar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">รายการเมนู</h4>
            </div>
            <div class="modal-body">
                <label>ชื่อ</label>
                <input type="text" id="title" class="form-control"/>
                <label>ประเภท</label>
                <select id="type" class="form-control">
                    <option value="0">ไม่มีเมนูย่อย</option>
                    <option value="1">มีเมนูย่อย</option>
                    <option value="2">ลิงค์ไปยังเว็บภายนอก</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="save_navbar()">บันทึก</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--
    ###### Type SubNavbar ######
-->
<div class="modal fade" tabindex="-1" role="dialog" id="dialog_add_subnavbar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">รายการเมนู</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="menu_id"/>
                <label>ประเภท</label>
                <select id="subtype" class="form-control">
                    <option value="0">สร้างหน้าเพจ</option>
                    <option value="2">ลิงค์ไปยังเว็บภายนอก</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="save_subnavbar()">บันทึก</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    function set_color(color, text, color_head) {
        $("#color").val(color);
        $("#color_text").val(text);
        $("#color_head").val(color_head);
        save();
    }

    function save() {
        var url = "<?php echo site_url('backend/menubar/save_style') ?>";
        var webname_short = $("#web_name_short").val();
        var webname_full = $("#web_name_full").val();
        var color_navbar = $("#color").val();
        var color_text = $("#color_text").val();
        var color_head = $("#color_head").val();
        var data = {
            webname_short: webname_short,
            webname_full: webname_full,
            color_navbar: color_navbar,
            color_text: color_text,
            color_head: color_head
        };

        $.post(url, data, function (success) {
            window.location.reload();
        });
    }

    function popup_add_navbar() {
        $("#dialog_add_navbar").modal();
    }

    function save_navbar() {
        var url = "<?php echo site_url('backend/menubar/save_navbar') ?>";
        var title = $("#title").val();
        var type = $("#type").val();

        var data = {
            title: title,
            type: type
        };

        $.post(url, data, function (datas) {
            var id = datas.id;
            if (type == '0') {
                window.location = "<?php echo base_url() ?>" + "index.php/backend/menubar/create_page" + "/" + id;
            } else if (type == '2') {
                window.location = "<?php echo base_url() ?>" + "index.php/backend/menubar/create_link" + "/" + id;
            } else {
                window.location.reload();
            }

        }, "json");
    }

    function delete_page(id) {
        var r = confirm("คุณแน่ใจหรือไม่ที่จะลบ ...");
        if (r == true) {
            var url = "<?php echo site_url('backend/menubar/delete') ?>";
            var data = {id: id};
            $.post(url, data, function (success) {
                window.location = "<?php echo site_url('backend/menubar') ?>";
            });
        }
    }


    function popup_add_subnavbar(id) {
        $("#menu_id").val(id);
        $("#dialog_add_subnavbar").modal();
    }

    function save_subnavbar() {
        var type = $("#subtype").val();
        var id = $("#menu_id").val();
        if (type == '0') {
            window.location = "<?php echo base_url() ?>" + "index.php/backend/menubar/create_subpage" + "/" + id;
        } else if (type == '2') {
            window.location = "<?php echo base_url() ?>" + "index.php/backend/menubar/create_sublink" + "/" + id;
        } else {
            window.location.reload();
        }

    }
</script>
