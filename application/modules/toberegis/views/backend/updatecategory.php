<style type="text/css">
    .row{
        margin-top: 10px;
    }
</style>
<?php
$this->load->library('takmoph_libraries');
$modellib = new takmoph_libraries();

$list = array(
    array('url' => 'asbforum/backend', 'label' => 'จัดการ'),
    array('url' => 'asbforum/backend/category', 'label' => 'หมวด'),
);
$active = $head;
?>

<?php echo $modellib->breadcrumb_backend($list, $active); ?>
 <h3 id="head_submenu">
            <i class="fa fa-file-text-o fa-2x text-warning"></i>
            <?php
            echo $head;
            ?>
        </h3>

<hr id="hr"/>
<div class="row">
    <div class="col-md-2 col-lg-2">หมวด</div>
    <div class="col-md-10 col-lg-10">
        <input type="text" class="form-control" id="title" value="<?php echo $model->title ?>"/>
    </div>
</div>
<div class="row">
    <div class="col-md-2 col-lg-2">รายละเอียด</div>
    <div class="col-md-10 col-lg-10">
        <textarea class="form-control" rows="5" id="detail"><?php echo $model->detail ?></textarea>
    </div>
    <div class="col-md-2 col-lg-2"></div>
    <div class="col-md-4 col-lg-4"><input type="checkbox" id="level" <?php if($model->level == 1){ echo "checked";}?>/> มีหัวข้อย่อยในหมวดนี้</div>
</div>
<div class="row">
    <div class="col-md-2 col-lg-2"></div>
    <div class="col-md-4 col-lg-4"><input type="checkbox" id="active" <?php if($model->active == "Y"){ echo "checked";}?>/> Active</div>

</div>
<hr/>
<div class="row">
    <div class="col-md-2 col-lg-2"></div>
    <div class="col-md-3 col-lg-3">
        <button type="button" class="btn btn-success btn-sm" onclick="Save()">บันทึกข้อมูล</button>
    </div>
</div>

<script type="text/javascript">
    function Save() {
        var url = "<?php echo site_url('asbforum/backend/saveupdatecategory') ?>";
        var title = $("#title").val();
        var detail = $("#detail").val();
        var level = $("#level").is(':checked') ? 1 : 0;
        var active = $("#active").is(':checked') ? 'Y' : 'N';
        //var catid = "<?php //echo $catID ?>";
        var id = "<?php echo $model->id ?>";
        var data = {id: id,title: title, detail: detail, level: level,active: active};

        if (title == "") {
            $("#title").focus();
            return false;
        }
        if (detail == "") {
            $("#detail").focus();
            return false;
        }

        $.post(url, data, function (datas) {
            window.location="<?php echo site_url('asbforum/backend/category')?>";
        });

    }
</script>