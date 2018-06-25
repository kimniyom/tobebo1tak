
<script type="text/javascript">
    $(document).ready(function () {
        $('#file_upload').uploadify({
            'buttonText': 'กรุณาเลือกไฟล์ ...',
            'auto': true, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('upload_photo/upload_icon_menu_admin/' . $id) ?>', //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
            'fileSizeLimit': '100MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
            'width': '350',
            'height': '40',
            'fileTypeExts': '*.jpg; *.JPEG; *.png; *.gif;', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
            'multi': true, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
            'queueSizeLimit': 1, //อัพโหลดได้ครั้งละ 5 ไฟล์
            'onUploadComplete': function (success) { //เมื่ออัพโหลดเสร็จแล้วให้เรียกใช้งาน function load()
                window.location = "<?= site_url('takmoph_admin/from_admin_menu/'); ?>";
            }
        });
    });
</script>

<div id="container">
    <h1><?= $head ?></h1>
    <div id="body">
        <center>
            อัพโหลดได้ไม่เกินครั้งละ 100MB,
            อัพโหลดได้ไม่เกินครั้งละ 1 ไฟล์
            <br /><br />
            <form>
                <div id="queue"></div>
                <div style="width:350px;">
                    <input id="file_upload" name="file_upload" type="file" multiple>
                </div>
            </form><br /><br /><br />
        </center>
    </div>
    <p class="footer">&nbsp;</p>
</div>
