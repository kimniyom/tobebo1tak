<?php $path = base_url() . "assets/CK-Editor/"; ?>
<script src="<?= base_url() ?>assets/CK-Editor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //Modify By Kimniyom

        CKEDITOR.replace('page', {
            //baseUrl: 'http://localhost/takmoph2015upgrad/EDITOR_FILE/',
            //baseDir = 'd:\inetpub\wwwroot\www.yourdomain.com\website\assets\images\',
            language: 'th',
            height: 500,
            uiColor: '#FFFFFF',
            removePlugins: 'bidi,forms,flash,iframe,tabletools,find',
            removeButtons: 'Anchor,Underline,Strike,Subscript,Superscript,Editing,Templates,Preview,NewPage,Source,Save,Scayt,About',
            filebrowserBrowseUrl: '<?php echo $path; ?>ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl: '<?php echo $path; ?>ckfinder/ckfinder.html?Type=Images',
            //filebrowserFlashBrowseUrl: '<?//php echo $path; ?>ckfinder/ckfinder.html?Type=Flash',
            filebrowserUploadUrl: '<?php echo $path; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl: '<?php echo $path; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
                    //filebrowserFlashUploadUrl: '<?//php echo $path; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        });
    });
    function Save_page() {
        var url = "<?php echo site_url('backend/menubar/save_update_page') ?>";
        var title = $("#title").val();
        var page = CKEDITOR.instances.page.getData();
        var id = "<?php echo $page->id ?>";
        if (title == '' || page == '') {
            alert("กรอกข้อมูลไม่ครบ ...");
            return false;
        }
        var data = {
            title: title,
            page: page,
            id: id
        };
        $.post(url, data, function (success) {
            window.location = "<?php echo site_url() ?>backend/menubar";
        });
    }
</script>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'backend/menubar', 'label' => 'MenuBar'),
        //array('url' => '', 'label' => 'menu2')
);

$active = $head;
//$list = "";
echo $model->breadcrumb_backend($list, $active);
?>
<h3><i class="fa fa-newspaper-o"></i> <?php echo $head ?></h3>
<hr/>
<div class="form-group">
    <label>เรื่อง</label>
    <input type="text" class="form-control" id="title" value="<?php echo $page->title ?>"/>
    <label>รายละเอียด</label>
    <textarea id="page" class="form-control"><?php echo $page->page ?></textarea>
    <hr/>
    <button type="button" class="btn btn-primary" onclick="Save_page()">บันทึกข้อมูล</button>
</div>
