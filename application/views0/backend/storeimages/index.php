<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
);

$active = $head;
echo $model->breadcrumb_backend($list, $active);
?>

<br/>
<h3><i class="fa fa-photo"></i> <?php echo $head ?></h3>
<hr/>
<div class="row">
    <div class="col-md-3 col-lg-3">
        <div class="list-group">
            <a href="javascript:popupcreatefolder()" class="list-group-item"><i class="fa fa-plus-square-o"></i> <i class="fa fa-folder-o"></i> โฟลเดอร์</a>
            <?php foreach ($folder->result() as $rs): ?>
                <a href="" class="list-group-item"><i class="fa fa-folder text-success"></i> <?php echo $rs->folder_name ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-md-9 col-lg-9">

    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" data-backdrop='static' id="popupcreatefolder">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">สร้างโฟลเดอร์</h4>
            </div>
            <div class="modal-body">
                <label>ชื่อโฟลเดอร์</label>
                <input type="text" id="foldername" class="form-control"/>
                <br/>*ชื่อต้องไม่ซ้ำ
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="createfolder()"><i class="fa fa-save"></i> สร้าง</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    function popupcreatefolder() {
        $("#popupcreatefolder").modal();
    }

    function createfolder() {
        var url = "<?php echo site_url('backend/storeimages/createfolder') ?>";
        var foldername = $("#foldername").val();
        if (foldername == "") {
            $("#foldername").focus();
            return false;
        }
        var data = {foldername: foldername};
        $.post(url, data, function (datas) {
            if (datas == '0') {
                alert("ชื่อซ้ำ ...!");
                return false;
            } else {
                window.location.reload();
            }
        });
    }
</script>

