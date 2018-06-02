<script type="text/javascript">
    $(document).ready(function () {
        //loaddata();
        $('[data-toggle="tooltip"]').tooltip();

        $('#file_upload').uploadify({
            'buttonText': 'เลือกรูปภาพ ...',
            'auto': true, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('asbforum/albumphoto/uoloads/' . $album_id) ?>', //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
            'fileSizeLimit': '1MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
            //'width': '350',
            //'height': '40',
            'fileTypeExts': '*.gif; *.JPG; *.jpg; *jpeg; *.png', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
            'multi': true, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
            'queueSizeLimit': 5, //อัพโหลดได้ครั้งละ 5 ไฟล์
            'onUploadComplete': function (file, data, response) { //เมื่ออัพโหลดเสร็จแล้วให้เรียกใช้งาน function load()
                //loaddata();
                if (response != "0") {
                    $("#log").append("Upload Images " + file.name + " Success <br/>");
                    $("#show_log").show();
                } else {
                    window.location = "<?php echo site_url('asbforum/albumphoto/') ?>";
                }
            }
        });
    });
</script>

<div class="panel panel-default">
    <div class="panel-heading"></div>
    <div class="panel-body">
        อัพโหลดได้ไม่เกินครั้งละ 1 mb<br/>
        นามสกุลไฟล์ gif jpg png
        <br /><br />
        <p style="color: #ff0000;">* หมายเหตุขนาดไฟล์อัพโหลดขึ้นอยู่กับการรับโหลดที่ server ด้วย</p>
        <form>
            <div id="queue"></div>
            <div style="width:350px;">
                <input id="file_upload" name="file_upload" type="file" multiple>
            </div>
        </form>

    </div>
</div>

