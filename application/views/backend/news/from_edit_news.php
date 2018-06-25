<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php $path = base_url() . "assets/CK-Editor/"; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="text/javascript">
            $(document).ready(function () {
                //$("#detailnews").Editor();
                //Modify By Kimniyom
                CKEDITOR.replace('_detail', {
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

            function edit_news() {
                //var _detail = $("#_detail").Editor("getText");
                var _detail = CKEDITOR.instances._detail.getData();

                if (_detail == "") {
                    alert("กรอกรายละเอียด ...?");
                    return false;
                }
                var data = {
                    _new_id: $("#_new_id").val(),
                    _title: $("#_title").val(),
                    _detail: _detail
                };

                $.ajax({
                    type: "POST",
                    url: "<?= site_url('backend/news/edit_news') ?>",
                    data: data,
                    success: function () {
                        window.location.reload();
                    }
                });
            }

        </script>
    </head>

    <body>
        <input type="hidden" id="_new_id" name="_new_id" value="<?= $news->id ?>"/>
        <label>หัวข้อข่าว</label>
        <input type="text" id="_title" name="_title" style="width:98%;" class="form-control input-mini" required="required" value="<?= $news->titel ?>"/>
        <label>รายละเอียด</label>
        <textarea  id="_detail" name="_detail" rows="5" class="form-control"><?= $news->detail ?></textarea><br/>
        <input type="button" class="btn btn-success" value="บันทึกข้อมูล" onclick="edit_news()"/>
        <input type="reset" class="btn btn-danger" value="ยกเลิก" />

    </body>
</html>