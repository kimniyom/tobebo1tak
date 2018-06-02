<!--main-->
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
        //array('url' => '', 'label' => 'menu2')
);

$active = $head;
//$list = "";
echo $model->breadcrumb_backend($list, $active);
?>

<h3 id="head_submenu"><i class="fa fa-newspaper-o"></i> <?php echo $head ?></h3>
<hr id="hr"/>
<button type="button" class="btn btn-default" onclick="create()"><i class="fa fa-plus text-success"></i> สร้างอัลบั้มใหม่ ...</button>
<br/><br/>
<div class="row">
    <?php
    $i = 0;
    foreach ($album->result() as $albums): $i++;
        $images = $this->photo->get_first_album($albums->id);
        ?>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
            <div class="container-card" style="height:350px;">
                <div class="img-wrapper">
                    <?php if (!empty($images)) { ?>
                        <img src="<?php echo base_url() ?>upload_images/photo/<?php echo $images; ?>" class="img-responsive img-polaroid" style="height:200px;"/>
                    <?php } else { ?>
                        <center>
                            <img src="<?php echo base_url() ?>upload_images/photo/<?php echo $images; ?>" class="img-responsive img-polaroid" style="height:200px;"/>
                        </center>
                    <?php } ?>
                </div>
                <p class="detail">
                    <?php
                    $text = strlen($albums->title);
                    if ($text > 160) {
                        //echo iconv_substr($news->titel,'0','100')."...";
                        if ($this->session->userdata('width') > 1000 || $this->session->userdata('width') <= 768) {
                            print mb_substr($albums->title, 0, 40, 'UTF-8') . "...";
                        } else {
                            echo $albums->title;
                        }
                    } else {
                        echo $albums->title;
                    }
                    ?>
                    <br/>
                    <font style=" font-size: 12px;" class="pull-right">
                    <?php echo $model->thaidate($albums->create_date) ?>
                    </font>
                </p>

                <div id="btn-card">
                    <a href="<?php echo site_url('backend/photo/create_gallery/' . $albums->id) ?>">
                        <button type="button" class="btn btn-default btn-sm">
                            <i class="fa fa-plus text-success"></i> เพิ่ม</button></a>
                    <button type="button" class="btn btn-default btn-sm"
                            onclick="edit('<?php echo $albums->id ?>')">
                        <i class="fa fa-pencil text-info"></i> แก้ไข
                    </button>
                    <button type="button" class="btn btn-default btn-sm" onclick="delete_album('<?php echo $albums->id ?>')">
                        <i class="fa fa-trash text-danger"></i> ลบ</button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div style="text-align:center;">
    <?php echo $s_pagination ?>
</div>
</div

<!--
  ####### Inser Update Delete ##########
-->
<div class="modal fade" tabindex="-1" role="dialog" id="popup_create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> <i class="fa fa-file-image-o"></i> สร้างอัลบ้ัม</h4>
            </div>
            <div class="modal-body">
                <label>ชื่อ</label>
                <input type="text" class="form-control" id="title"/>
                <label>รายละเอียด</label>
                <textarea class="form-control" id="detail" rows="5"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove text-danger"></i> ปิด</button>
                <button type="button" class="btn btn-default" onclick="save_create()"><i class="fa fa-save text-success"></i> บันทึกข้อมูล</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--
  ### Popup Edit Album
-->
<div class="modal fade" tabindex="-1" role="dialog" id="popup_edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> <i class="fa fa-file-image-o"></i> แก้ไขอัลบ้ัม</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="album_id"/>
                <label>ชื่อ</label>
                <input type="text" class="form-control" id="update_title"/>
                <label>รายละเอียด</label>
                <textarea class="form-control" id="update_detail" rows="5"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove text-danger"></i> ปิด</button>
                <button type="button" class="btn btn-default" onclick="save_edit()"><i class="fa fa-save text-success"></i> บันทึกข้อมูล</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    function create() {
        $("#popup_create").modal();
    }

    function save_create() {
        var url = "<?php echo site_url('backend/photo/save_album') ?>";
        var title = $("#title").val();
        var detail = $("#detail").val();
        var data = {
            title: title,
            detail: detail
        };
        if (title == "") {
            $("#title").focus();
            return false;
        }

        $.post(url, data, function (result) {
            var id = result.id;
            window.location = "<?php echo base_url() ?>index.php/backend/photo/create_gallery/" + id;
        }, "json");
    }

    function edit(id) {
        $("#popup_edit").modal();
        var url = "<?php echo site_url('backend/photo/get_album') ?>";
        var data = {id: id};
        $.post(url, data, function (datas) {
            $("#album_id").val(id);
            $("#update_title").val(datas.title);
            $("#update_detail").val(datas.detail);
        }, "json");
    }


    function save_edit() {
        var url = "<?php echo site_url('backend/photo/save_edit') ?>";
        var id = $("#album_id").val();
        var title = $("#update_title").val();
        var detail = $("#update_detail").val();
        var data = {
            id: id,
            title: title,
            detail: detail
        };
        if (title == "") {
            $("#update_title").focus();
            return false;
        }

        $.post(url, data, function (result) {
            swal({title: "Success", text: "แก้ไขข้อมูลแล้ว ...", type: "success",
                showCancelButton: false,
                loseOnConfirm: true,
                showLoaderOnConfirm: false},
                    function () {
                        //swal("Success","แก้ไขข้อมูลแล้ว ...","success");
                        window.location.reload();
                    });
        });
    }
</script>

<script type="text/javascript">
    function delete_album(id) {
        var r = confirm("คุณแน่ใจหรือไม่ ... ?");
        if (r == true) {
            var url = "<?php echo site_url('backend/photo/delete_album') ?>";
            var id = id;
            var data = {album_id: id};
            $.post(url, data, function (success) {
                swal({title: "Success", text: "ลบข้อมูลแล้ว ...", type: "success",
                    showCancelButton: false,
                    loseOnConfirm: true,
                    showLoaderOnConfirm: false},
                        function () {
                            window.location.reload();
                        });
            });
        }
    }
</script>
