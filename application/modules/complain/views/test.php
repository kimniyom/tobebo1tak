<?php $path = base_url() . "assets/CK-Editor/"; ?>
<script src="<?= base_url() ?>assets/CK-Editor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //$("#detailnews").Editor();

        //Modify By Kimniyom
        CKEDITOR.replace('detailnews', {
            //image_removeLinkByEmptyURL: true
            //extraPlugins: 'image',
            //removeDialogTabs: 'link:upload;image:Upload',
            //filebrowserBrowseUrl: 'imgbrowse/imgbrowse.php',
            //filebrowserUploadUrl: 'ckupload.php',
            filebrowserBrowseUrl: '<?php echo $path; ?>ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl: '<?php echo $path; ?>ckfinder/ckfinder.html?Type=Images',
            //filebrowserFlashBrowseUrl: '<?//php echo $path; ?>ckfinder/ckfinder.html?Type=Flash',
            filebrowserUploadUrl: '<?php echo $path; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl: '<?php echo $path; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
                    //filebrowserFlashUploadUrl: '<?//php echo $path; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#from").submit(function () {
            //var detail = $("#detailnews").Editor("getText");
            var detail = CKEDITOR.instances.detail_complain.getData();
            alert(detail);
            if (detail == "") {
                alert("กรอกรายละเอียด ...?");
                return false;
            }
            var data = {
                new_id: $("#new_id").val(),
                title: $("#title").val(),
                detail: detail
            };
            $.ajax({
                type: "POST",
                //url: "<?//= site_url('backend/news/save_news') ?>",
                data: data,
                success: function () {
                    window.location.reload();
                }
            });
        });
    });
</script>

<form id="from" name="from">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 id="myModalLabel">เพิ่มข่าว</h4>
    </div>
    <div class="modal-body">

        <input type="hidden"  id="new_id" name="new_id" value="<?= $this->tak->autoId('tb_news', 'id', '4'); ?>"/>
        <label>หัวข้อข่าว</label>
        <input type="text" id="title" name="title" style="width:98%;" required="required" class="form-control input-mini"/>
        <label>ผู้เผยแพร่</label>
        <input type="text" id="user_" name="user_" style="width:98%;"  class="form-control input-mini"
               value="<?= $this->session->userdata('name') . '-' . $this->session->userdata('lname'); ?>" readonly="readonly"/>
        <label>รายละเอียด</label>

        <textarea id="detail_complain" name="detailnews" rows="3"></textarea> 

    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-success" value="บันทึกข้อมูล" />
        <input type="reset" class="btn btn-danger" value="ยกเลิก" />
    </div>
</form>
