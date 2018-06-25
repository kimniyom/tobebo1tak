<!-- Upload -->
<script src="<?= base_url() ?>lib/js/jquery.uploadify-3.1.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>lib/css/uploadify.css">
<script type="text/javascript">
    $(document).ready(function () {
        $('#file_upload').uploadify({
            'buttonText': '<?php echo $buttonText ?>',
            'auto': true, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('backend/storeimages/' . $upload . '/' . $folder->id) ?>', //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
            'fileSizeLimit': '2MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
            //'width': '350',
            //'height': '40',
            'fileTypeExts': '<?php echo $filetype ?>', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
            'multi': true, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
            'queueSizeLimit': 5, //อัพโหลดได้ครั้งละ 5 ไฟล์
            'onQueueComplete': function (queueData) {
                alert(queueData.uploadsSuccessful + ' files were successfully uploaded.');
                getfolder('<?php echo $folder->id ?>');
            }
        });
    });
</script>

<h4>
    <i class="fa fa-folder"></i> <?php echo $folder->folder_name ?> 
    (<?php echo $sum ?>)
    <button type="button" class="btn btn-default" onclick="editfolder('<?php echo $folder->id ?>', '<?php echo $folder->folder_name ?>')">แก้ไข</button>
    <button type="button" class="btn btn-default" onclick="deletefolder('<?php echo $folder->id ?>')">ลบ</button>
</h4>
<hr/>

<form>
    <div style="width:350px;">
        <input id="file_upload" name="file_upload" type="file" multiple>
    </div>
</form>

<div id="listimages"></div>

<script type="text/javascript">
    getdata('<?php echo $folder->id ?>');
    function editfolder(id, foldername) {
        $("#_folder_id").val(id);
        $("#_foldername").val(foldername);
        $("#popupeditfolder").modal();

    }

    function saveedit() {
        var url = "<?php echo site_url('backend/storeimages/updatefolder') ?>";
        var folder_id = $("#_folder_id").val();
        var foldername = $("#_foldername").val();
        var data = {folder_id: folder_id, foldername: foldername};
        $.post(url, data, function (datas) {
            $("#popupeditfolder").modal('hide');
            getfolder(folder_id);
            getdata(folder_id);
        });
    }

    function getdata(folder_id) {
        var url = "<?php echo site_url('backend/storeimages/getdata') ?>";
        var data = {folder_id: folder_id};
        $.post(url, data, function (datas) {
            $("#listimages").html(datas);
        });
    }

    function deletefolder(id) {
        var r = confirm("Are you sure ...?");
        if (r == true) {
            var url = "<?php echo site_url('backend/storeimages/deletefolder') ?>";
            var data = {id: id};
            $.post(url, data, function (datas) {
                window.location.reload();
            });
        }
    }
</script>
