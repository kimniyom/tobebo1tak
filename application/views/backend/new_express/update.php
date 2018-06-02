<?php $path = base_url() . "assets/CK-Editor/"; ?>
<script src="<?= base_url() ?>assets/CK-Editor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //Modify By Kimniyom
        CKEDITOR.replace('detail', {
            //removePlugins: 'bidi,forms,flash,iframe,div,table,tabletools',
            //removeButtons: 'Anchor,Underline,Strike,Subscript,Superscript,Image',
            filebrowserBrowseUrl: '<?php echo $path; ?>ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl: '<?php echo $path; ?>ckfinder/ckfinder.html?Type=Images',
            //filebrowserFlashBrowseUrl: '<?//php echo $path; ?>ckfinder/ckfinder.html?Type=Flash',
            filebrowserUploadUrl: '<?php echo $path; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl: '<?php echo $path; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
                    //filebrowserFlashUploadUrl: '<?//php echo $path; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        });
    });

    function update_express() {
        var url = "<?php echo site_url('backend/newexpress/save_update') ?>";
        var title = $("#title").val();
        var detail = CKEDITOR.instances.detail.getData();
        var id = "<?php echo $model->id ?>";
        if (title == '' || detail == '') {
            alert("กรอกข้อมูลไม่ครบ ...");
            return false;
        }
        var data = {id: id, title: title, detail: detail};
        $.post(url, data, function (success) {
            var Id = success;
            window.location = "<?php echo site_url() ?>backend/newexpress/view/" + Id;
        });
    }

</script>

<?php
$this->load->library('takmoph_libraries');
$lib = new takmoph_libraries();

$text = strlen($model->title);
if ($text > 50) {
    $h = mb_substr($model->title, 0, 40, 'UTF-8') . "...";
} else {
    $h = $model->title;
}

$list = array(
    array('url' => 'backend/newexpress', 'label' => 'ประกาศ'),
    array('url' => 'backend/newexpress/view/' . $model->id, 'label' => $h)
);

$active = $head;
//$list = "";
echo $lib->breadcrumb_backend($list, $active);
?>
<h3><i class="fa fa-newspaper-o"></i> <?php echo $head ?></h3>
<hr/>
<div class="form-group">
    <label>เรื่อง</label>
    <input type="text" class="form-control" id="title" value="<?php echo $model->title ?>"/>
    <label>รายละเอียด</label>
    <textarea id="detail" class="form-control"><?php echo $model->detail ?></textarea>
    <hr/>
    <button type="button" class="btn btn-primary" onclick="update_express()">Save</button>
</div>

