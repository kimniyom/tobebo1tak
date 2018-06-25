<!-- ScriptUpload By Uploadify -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#file_upload').uploadify({
            'buttonText': 'กรุณาเลือก Template ...',
            'auto': true, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('backend/template/upload/') ?>', //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
            'fileSizeLimit': '10MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
            //'width': '350',
            //'height': '40',
            'fileTypeExts': '*.zip; *.rar;', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
            'multi': false, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
            'queueSizeLimit': 1, //อัพโหลดได้ครั้งละ 5 ไฟล์
            'onUploadSuccess': function (file, data, response) { //เมื่ออัพโหลดเสร็จแล้วให้เรียกใช้งาน function load()        
                if (data == 'error') {
                    $("#status-install").show();
                    $("#log").append("<font style='color:red;'>! มีชื่อ Template อยู่ในระบบแล้ว ...</font><br/> ");
                } else {
                    window.location.reload();
                }
                //get_background();  
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
<br/>
อัพโหลดได้ไม่เกินครั้งละ 10MB,<br/>
อัพโหลดได้ไม่เกินครั้งละ 1 ไฟล์
<br /><br />
<form>
    <div id="queue"></div>
    <div style="width:350px;">
        <input id="file_upload" name="file_upload" type="file" multiple>
    </div>
</form><br />

<div class="alert alert-danger" id="status-install" style=" display: none;">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span><br/>

    </button>
    <div id="log"></div>
</div>

<h4>
    <i class="fa fa-image"></i>
    Template Install
</h4>
<hr/>

<div id="themes-template"></div>

<script>
    get_template();
    function get_template() {
        var url = "<?php echo site_url('backend/template/page') ?>";
        var data = {};
        $.post(url, data, function (html) {
            $("#themes-template").html(html);
        });
    }
</script>