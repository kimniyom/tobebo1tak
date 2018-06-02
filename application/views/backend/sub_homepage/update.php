<?php $path = base_url() . "assets/CK-Editor/"; ?>
<script src="<?= base_url() ?>assets/CK-Editor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //Modify By Kimniyom
        var type = "<?php echo $type ?>";
        if (type == 0) {
            CKEDITOR.replace('detail', {
                //baseUrl: 'http://localhost/takmoph2015upgrad/EDITOR_FILE/',
                //baseDir = 'd:\inetpub\wwwroot\www.yourdomain.com\website\assets\images\',
                language: 'th',
                height: 500,
                uiColor: '#FFFFFF',
                removePlugins: 'bidi,forms,flash,iframe,div,table,tabletools,find',
                removeButtons: 'Anchor,Underline,Strike,Subscript,Superscript,Editing,Templates,Preview,NewPage,Source,Save,Scayt,About',
                filebrowserBrowseUrl: '<?php echo $path; ?>ckfinder/ckfinder.html',
                filebrowserImageBrowseUrl: '<?php echo $path; ?>ckfinder/ckfinder.html?Type=Images',
                //filebrowserFlashBrowseUrl: '<?//php echo $path; ?>ckfinder/ckfinder.html?Type=Flash',
                filebrowserUploadUrl: '<?php echo $path; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                filebrowserImageUploadUrl: '<?php echo $path; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
                        //filebrowserFlashUploadUrl: '<?//php echo $path; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
            });
        }
    });

    function Save_update() {
        var url = "<?php echo site_url('backend/sub_homepage/save_update') ?>";
        var title = $("#title").val();
        var type = "<?php echo $type ?>";
        var create_date = $("#create_date").val();
        var detail;
        if (type == 0) {
            detail = CKEDITOR.instances.detail.getData();
        } else {
            detail = "";
        }

        var id = "<?php echo $result->id ?>";

        if (title == '') {
            alert("กรอกข้อมูลไม่ครบ ...");
            return false;
        }
        var data = {
            id: id,
            title: title,
            detail: detail,
            create_date: create_date
        };
        $.post(url, data, function (success) {
            window.history.back();
            //window.location = "<?//php echo site_url() ?>/backend/sub_homepage/view/" + id;
        });
    }
    
        
    $(function () {
        $('#create_dates').datetimepicker({
            defaultDate: "<?php echo $result->create_date ?>",
            format: 'YYYY-MM-DD'
        });
    });
</script>
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
if (!empty($type)) {
    $link = 'backend/sub_homepage/viewpper/' . $subhomepage_id . '/' . $result->homepage_id;
    $label = $result->title;
} else {
    $link = "";
    $label = "";
}
$list = array(
    array('url' => 'backend/homepage', 'label' => 'ตัวอย่าง'),
    array('url' => 'backend/sub_homepage/all/' . $result->homepage_id, 'label' => $result->title_name),
    array('url' => $link, 'label' => $label)
);

$active = "update";
//$list = "";
echo $model->breadcrumb_backend($list, $active);
?>
<h3>
    <i class="fa fa-newspaper-o"></i> 
    <?php
    $text = strlen($result->title);
    if ($text > 250) {
        //echo iconv_substr($news->titel,'0','100')."...";
        print mb_substr($result->title, 0, 50, 'UTF-8') . "...";
    } else {
        echo $result->title;
    }
    ?>

</h3>
<hr/>

<div class="form-group">
    <label>เรื่อง</label>
    <input type="text" class="form-control" id="title" value="<?php echo $result->title ?>"/>
    <?php if (empty($type)) { ?>
        <label>รายละเอียด</label>
        <textarea id="detail" class="form-control"><?php echo $result->detail ?></textarea>
    <?php } ?>
    <label>วันที่</label>
    <div class="form-group">
        <div class='input-group date' id='create_dates' style=" width: 30%;">
            <input type='text' class="form-control" id="create_date"/>
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    </div>
    <hr/>
    <button type="button" class="btn btn-primary" onclick="Save_update()">บันทึกข้อมูล</button>
</div>