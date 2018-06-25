<?php $path = base_url() . "assets/CK-Editor/"; ?>
<script src="<?= base_url() ?>assets/CK-Editor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //Modify By Kimniyom
        var type = "<?php echo $type ?>";
        if (type == 0) {
            CKEDITOR.replace('detail', {
                                toolbar: [
                //{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                {name: 'clipboard', groups: ['clipboard', 'undo'], items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
                //{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                //{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                '/',
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']},
                {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl']},
                {name: 'links', items: ['Link']}, //, 'Unlink', 'Anchor'
                //{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                {name: 'insert', items: ['Image', 'Youtube']},
                '/',
                {name: 'styles', items: ['Styles', 'Format', 'FontSize']}, /*Font*/
                {name: 'colors', items: ['TextColor', 'BGColor']},
                {name: 'tools', items: ['Maximize', 'ShowBlocks']}
                //{ name: 'others', items: [ '-' ] },
                //{ name: 'about', items: [ 'About' ] }
            ],
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

       function closeAll() {
        $('#popupstoreimages').modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    }

    function getstoreimages(type) {
        if (type == "0") {
            $("#myModalLabel").text("รูปภาพ");
        } else {
            $("#myModalLabel").text("ไฟล์");
        }
        var url = "<?php echo site_url('backend/storeimg/index') ?>" + "/" + type;
        $("#store-img").load(url);
        $("#popupstoreimages").modal();
    }

    function reloadstoreimg(type) {
        getstoreimages(type);
    }


    function Addcontent(folder, img, name, type) {
        var url = "<?php echo base_url() ?>upload_images/" + folder + "/" + img;
        var res = img.replace(".", "");
        var content;
        if (type == "0") {
            content = "<a href='"+ url +"' class='fancybox'>" + "<img src='" + url + "' style='width:500px;' id='img-post" + res + "'/></a>";
            //content = "<img src='" + url + "' style='width:500px;' id='img-post" + res + "'/>";
        } else {
            content = "<a href='" + url + "' id='img-post" + res + "' target='_blank'><b>" + name + "</b></a>";
        }

        var detail = CKEDITOR.instances.detail.getData();
        CKEDITOR.instances.detail.setData(detail + content);
        closeAll();
    }
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
    <br/>
    <button type="button" class="btn btn-default" onclick="getstoreimages('0')"><i class="fa fa-image"></i> แทรกรูปภาพในเนื้อหา</button>
    <button type="button" class="btn btn-default" onclick="getstoreimages('1')"><i class="fa fa-link"></i> แทรกไฟล์ในเนื้อหา</button>
    <br/><br/>
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

<!-- Popup Add Images -->
<div class="modal fade" id="popupstoreimages" data-backdrop="static">
    <div class="modal-dialog" style=" width: 100%; margin: 5px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class=" pull-right" onclick="closeAll()"><span>&times;</span></button>
                <h4 id="myModalLabel"></h4>
            </div>
            <div class="modal-body" id="b-img" style=" overflow: auto; position: relative;"> 
                <div id="store-img"></div>
            </div>
        </div>
    </div>
</div>