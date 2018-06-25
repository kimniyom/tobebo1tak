<!-- ScriptUpload By Uploadify -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#file_upload').uploadify({
            'buttonText': 'อัพโหลดภาพพื้นหลัง ...',
            'auto': true, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('backend/background/upload/') ?>', //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
            'fileSizeLimit': '2MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
            //'width': '350',
            //'height': '40',
            'fileTypeExts': '*.gif; *.jpg; *.png; *.JPG;', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
            'multi': false, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
            'queueSizeLimit': 1, //อัพโหลดได้ครั้งละ 5 ไฟล์
            'onUploadComplete': function (success) { //เมื่ออัพโหลดเสร็จแล้วให้เรียกใช้งาน function load()
                get_background();
            }
        });
    });

</script>


<form>
    <div id="queue"></div>
    <div style="width:350px;">
        <input id="file_upload" name="file_upload" type="file" multiple>
    </div>
</form>

<hr/>

<div class="row">
    <?php
    $i = 0;
    foreach ($bg->result() as $rs): $i++;
        ?>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
            
                <div class="container-card" style="height:150px;">
                    <figure>
                        <div class="img-wrapper">
                            <?php if (!empty($rs->background)) { ?>
                                <img src="<?php echo base_url() ?>upload_images/bg/<?php echo $rs->background; ?>" class="img-responsive img-polaroid" style="height:150px;"/>
                            <?php } else { ?>
                                <center>
                                    <img src="<?php echo base_url() ?>images/no-sign_1334604348.png" class="img-responsive img-polaroid" style="height:150px;"/>
                                </center>
                            <?php } ?>
                        </div>
                    </figure>
                    <div id="btn-card">
                        <button type="button" class="btn btn-default btn-sm" onclick="select_bg('<?php echo $rs->id ?>','<?php echo $rs->background ?>')">
                            <i class="fa fa-check text-success"></i> ใช้งาน</button>
                        <button type="button" class="btn btn-default btn-sm" onclick="delete_bg('<?php echo $rs->id ?>','<?php echo $rs->background ?>')">
                            <i class="fa fa-trash text-danger"></i> ลบ</button>
                    </div>
                </div>
           
        </div>
    <?php endforeach; ?>
</div>

<!--
  ####### Inser Update Delete ##########
-->


<script type="text/javascript">
    function delete_bg(id,bg) {
        var r = confirm("คุณแน่ใจหรือไม่ ... ?");
        if (r == true) {
            var url = "<?php echo site_url('backend/background/delete') ?>";
            var id = id;
            var data = {
                id: id,
                bg: bg
            };
            $.post(url, data, function (success) {
                swal({title: "Success", text: "ลบข้อมูลแล้ว ...", type: "success",
                    showCancelButton: false,
                    loseOnConfirm: true,
                    showLoaderOnConfirm: false},
                        function () {
                            get_background();
                        });
            });
        }
    }

    function set_bg(id) {
        var url = "<?php echo site_url('backend/background/set_bg') ?>";
        var id = id;
        var data = {id: id};
        $.post(url, data, function (success) {
            swal({title: "Success", text: "ตั้งค่าพื้นหลังสำเร็จ ...", type: "success",
                showCancelButton: false,
                loseOnConfirm: true,
                showLoaderOnConfirm: false},
                    function () {
                        window.location.reload();
                    });
        });
    }
</script>
