<!-- ScriptUpload By Uploadify -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#file_upload').uploadify({
            'buttonText': 'เลือกรูปภาพ ...',
            'auto': true, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('backend/manager/upload') ?>', //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
            'fileSizeLimit': '1MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
            //'width': '350',
            //'height': '40',
            'fileTypeExts': '*.png; *.jpg;*.jpeg;', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
            'multi': false, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
            'queueSizeLimit': 1, //อัพโหลดได้ครั้งละ 5 ไฟล์
            'onUploadSuccess': function (file, data, response) { //เมื่ออัพโหลดเสร็จแล้วให้เรียกใช้งาน function load()        
                window.location.reload();  
            }
        });
    });

</script>

<?php
$this->load->library('takmoph_libraries');
$lib = new takmoph_libraries();

$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
        //array('url' => '', 'label' => 'menu2')
);

$active = $head;
?>

<div class="row" style=" margin: 0px; padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 0px;">
        <h3 id="head_submenu"><i class="fa fa-magic"></i> <?php echo $head ?></h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-right: 0px;">
        <?php echo $lib->breadcrumb_backend($list, $active); ?>
    </div>
</div>

<hr id="hr"/>
    <div class="row">
        <div class="col-md-3 col-lg-3">
            <img src="<?php echo base_url()?>upload_images/manager/<?php echo $datas->images ?>" width="120" class="img-responsive"/>
                <input id="file_upload" name="file_upload" type="file" multiple>
            อัพโหลดได้ไม่เกินครั้งละ 1MB<br/>
            อัพโหลดได้ไม่เกินครั้งละ 1 ไฟล์
        </div>
        <div class="col-md-6 col-lg-6">
            <label>ชื่อ - สกุล *</label>
            <input type="text" class="form-control" id="name" value="<?php echo $datas->name ?>"/> 
            <label>ตำแหน่ง *</label>
            <input type="text" class="form-control" id="position" value="<?php echo $datas->position ?>"/>
            <label>รายละเอียด</label>
            <textarea type="textarea" class="form-control" id="detail"><?php echo $datas->detail ?></textarea>
            <br/>
            <input type="radio" value="1" name="active" <?php if($datas->active == '1') echo "checked";?>/> แสดง
            <input type="radio" value="0" name="active" <?php if($datas->active == '0') echo "checked";?>/> ไม่แสดง
            <br/><br/>
            <button type="button" class="btn btn-success" onclick="save()"><i class="fa fa-save"></i> บันทึกข้อมูล</button>
        </div>
    </div>
    ​

<script>
    //loadmenager();
    function loadmenager() {
        var url = "<?php echo site_url('backend/manager/loadmanager') ?>";
        var data = {};
        $.post(url, data, function (html) {
            $("#themes-template").html(html);
        });
    }

    function save(){
        var url = "<?php echo site_url('backend/manager/save')?>";
        var name = $("#name").val();
        var position = $("#position").val();
        var detail = $("#detail").val();
        var active = $("input[name='active']:checked").val();
        var data = {name: name,position: position,detail: detail,active: active};
        if(name == '' || position == ''){
            alert("กรอกข้อมูลไม่ครบ ...");
            return false;
        }
        $.post(url,data,function(datas){
            window.location.reload();
        });
    }
</script>