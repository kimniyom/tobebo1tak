<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$strModel = new tobestoreimages_model();
?>
<div id="box-content-store">
    <div class="row">
        <div class="col-md-3 col-lg-3">
            <div class="list-group">
                <a href="javascript:popupcreatefolder()" class="list-group-item" style=" border: #cccccc dashed 2px;"><i class="fa fa-plus-square-o"></i> <i class="fa fa-folder-o"></i> โฟลเดอร์</a>
            </div>

            <div id="b-folder-left">
                <div class="list-group">
                    <?php foreach ($folder->result() as $rs): ?>
                        <a href="javascript:getfolder('<?php echo $rs->id ?>','<?php echo $rs->type ?>')" class="list-group-item">
                            <img src="<?php echo base_url() ?>/icon_menu/<?php echo ($rs->type == "1") ? "folder-file-icon.png" : "folder-img-icon.png"; ?>"/>
                            <label id="label-<?php echo $rs->id ?>"><?php echo $rs->folder_name ?></label>
                            <em>(<?php echo $strModel->count($rs->id); ?>)</em></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-lg-9">
            <div id="viewfolder"></div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" data-backdrop='static' id="popupcreatefolder">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="$('#popupcreatefolder').modal('hide');"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">สร้างโฟลเดอร์</h4>
            </div>
            <div class="modal-body">
                <label>ชื่อโฟลเดอร์</label>
                <input type="text" id="foldername" class="form-control"/>
                <br/>*ชื่อต้องไม่ซ้ำ
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="$('#popupcreatefolder').modal('hide');">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="createfolder()"><i class="fa fa-save"></i> สร้าง</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" data-backdrop='static' id="popupeditfolder">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="$('#popupeditfolder').modal('hide');"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">แก้ไขโฟลเดอร์</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" value="" id="_folder_id" />
                <label>ชื่อโฟลเดอร์</label>
                <input type="text" id="_foldername" class="form-control"/>
                <br/>*ชื่อต้องไม่ซ้ำ
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="$('#popupeditfolder').modal('hide');">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="saveedit()"><i class="fa fa-save"></i> แก้ไข</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- POPUP EDIT IMAGES -->
<div class="modal fade" tabindex="-1" role="dialog" data-backdrop='static' id="popupeditimagename">
    <div class="modal-dialog" role="document">
        <input type="hidden" id="_idimg"/>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="$('#popupeditimagename').modal('hide');"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">แก้ไขโฟลเดอร์</h4>
            </div>
            <div class="modal-body">
                <label>ชื่อรูปภาพ</label>
                <input type="text" id="_imagename" class="form-control"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="$('#popupeditimagename').modal('hide');">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="saveeditimage()"><i class="fa fa-save"></i> แก้ไข</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    getfolder('<?php echo $folder_default ?>', '<?php echo $type ?>');
    function popupcreatefolder() {
        $("#popupcreatefolder").modal();
    }

    function setcontentfolder() {
        var height = window.innerHeight;
        var left = (height - 180);
        $("#b-folder-left").css({'height': left, 'overflow': 'auto', 'background': '#eeeeee', 'padding': '5px', 'border-radius': '5px'});
    }

    function createfolder() {
        var url = "<?php echo site_url('toberegis/storeimg/createfolder') ?>";
        var foldername = $("#foldername").val();
        var type = "<?php echo $type ?>";
        if (foldername == "") {
            $("#foldername").focus();
            return false;
        }
        var data = {foldername: foldername, type: type};
        $.post(url, data, function (datas) {
            if (datas == '0') {
                alert("ชื่อซ้ำ ...!");
                return false;
            } else {
                reloadstoreimg(type);
                //window.location.reload();
            }
        });
    }

    function getfolder(id, type) {
        if (id != "") {
            var url = "<?php echo site_url('toberegis/storeimg/viewfolder') ?>";
            var data = {id: id, type: type};
            $.post(url, data, function (datas) {
                $("#viewfolder").html(datas);
            });
        }
    }

    setcontentfolder();

</script>

