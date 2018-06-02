<?php $path = base_url() . "assets/CK-Editor/"; ?>
<script src="<?= base_url() ?>assets/CK-Editor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //Modify By Kimniyom
        var admin = "<?php echo $this->session->userdata('status') ?>";
        if (admin == "S") {
            CKEDITOR.replace('detail', {
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
        } else {
            CKEDITOR.replace('detail', {
                language: 'th',
                height: 500,
                uiColor: '#FFFFFF',
                removePlugins: 'bidi,forms,flash,iframe,div,table,tabletools,find',
                removeButtons: 'Anchor,Underline,Strike,Subscript,Superscript,Editing,Templates,Preview,NewPage,Source,Save,Scayt,About',
                /*
                 filebrowserBrowseUrl: '<?//php echo $path; ?>ckfinder/ckfinder.html',
                 filebrowserImageBrowseUrl: '<?//php echo $path; ?>ckfinder/ckfinder.html?Type=Images',
                 */
                //filebrowserFlashBrowseUrl: '<?//php echo $path; ?>ckfinder/ckfinder.html?Type=Flash',
                filebrowserUploadUrl: '<?php echo $path; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                filebrowserImageUploadUrl: '<?php echo $path; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
                        //filebrowserFlashUploadUrl: '<?//php echo $path; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
            });
        }

    });
    function Save_upper() {
        var url = "<?php echo site_url('backend/sub_homepage/save_upper') ?>";
        var title = $("#title").val();
        var detail = CKEDITOR.instances.detail.getData();
        var homepage_id = "<?php echo $homepage_id ?>";
        var upper = "<?php echo $menu->id ?>";
        var create_date = $("#create_date").val();
        if (title == '' || detail == '') {
            alert("กรอกข้อมูลไม่ครบ ...");
            return false;
        }
        var data = {
            title: title,
            detail: detail,
            upper: upper,
            homepage_id: homepage_id,
            create_date: create_date
        };
        $.post(url, data, function (success) {
            //window.location.reload();
            window.location = "<?php echo base_url() ?>backend/sub_homepage/viewpper" + "/" + upper + "/" + homepage_id;
        });
    }
    
    $(function () {
        $('#create_dates').datetimepicker({
            defaultDate: "<?php echo date("Y-m-d")?>",
            format: 'YYYY-MM-DD'
        });
    });
</script>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'backend/homepage', 'label' => 'ตัวอย่าง'),
    array('url' => 'backend/sub_homepage/viewpper/' . $menu->id . '/' . $homepage_id, 'label' => $menu->title_name)
);

$active = "เพิ่ม";
//$list = "";
echo $model->breadcrumb_backend($list, $active);
?>
<h3><i class="fa fa-newspaper-o"></i> <?php echo $head ?></h3>
<hr/>
<div class="form-group">
    <label>เรื่อง</label>
    <input type="text" class="form-control" id="title"/>
    <label>รายละเอียด</label>
    <textarea id="detail" class="form-control"></textarea>
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
    <button type="button" class="btn btn-primary" onclick="Save_upper()">บันทึกข้อมูล</button>
</div>
