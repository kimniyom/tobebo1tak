<style type="text/css">
    .t_box{ width:97%;}
</style>

<script type="text/javascript">
    $(document).ready(function () {

        $('[data-toggle="tooltip"]').tooltip();

        $('#file_upload').uploadify({
            'buttonText': 'เลือก Icons ...',
            'auto': true, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('backend/icons/uoload_icon') ?>', //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
            'fileSizeLimit': '1MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
            //'width': '350',
            //'height': '40',
            'fileTypeExts': '*.gif; *.jpg; *.png', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
            'multi': true, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
            'queueSizeLimit': 1, //อัพโหลดได้ครั้งละ 5 ไฟล์
            'onUploadComplete': function (success) { //เมื่ออัพโหลดเสร็จแล้วให้เรียกใช้งาน function load()
                //window.location.reload();
            }
        });
    });
</script>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#tb_mas_menu').dataTable({
            "bJQueryUI": false,
            //"sPaginationType" : "full_numbers",// แสดงตัวแบ่งหน้า
            "bLengthChange": false, // แสดงจำนวน record ที่จะแสดงในตาราง
            "iDisplayLength": 10, // กำหนดค่า default ของจำนวน record
            //"sScrollY": "100px",
            "bFilter": false, // แสดง search box
            "oLanguage": {
                "sLengthMenu": "แสดง _MENU_ เร็คคอร์ด ต่อหน้า",
                "sZeroRecords": "ไม่เจอข้อมูลที่ค้นหา",
                "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ เร็คคอร์ด",
                "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 เร็คคอร์ด",
                "sInfoFiltered": "(จากเร็คคอร์ดทั้งหมด _MAX_ เร็คคอร์ด)",
                "sSearch": "ค้นหา :",
                "oPaginate": {
                    "sFirst": "หน้าแรก",
                    "sLast": "หน้าสุดท้าย",
                    "sNext": "ถัดไป",
                    "sPrevious": "กลับ"
                }
            }
        });
    });
</script>


<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
        //array('url' => 'backend/form_download/get_mas_from', 'label' => 'แบบฟอร์ม'),
);

$active = "Icon";
echo $model->breadcrumb_backend($list, $active);
?>

<h3><i class="fa fa-smile-o"></i> <?= $head ?></h3>

<hr/>

<div class="row">
    <div class="col-md-4 col-lg-3">
        <!-- Add Icon -->
        อัพโหลดได้ไม่เกินครั้งละ 1mb<br/>
        อัพโหลดได้ไม่เกินครั้งละ 1 ไฟล์<br/><br/>
        นามสกุลไฟล์ gif jpg png
        <br /><br />
        <form>
            <div id="queue"></div>
            <div style="width:350px;">
                <input id="file_upload" name="file_upload" type="file" multiple>
            </div>
        </form>
    </div>
    <div class="col-md-8 col-lg-9">

        <?php $i = 1;
        foreach ($icon->result() as $rs): ?>
            <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2" style="margin-bottom: 20px;">
                <div class="btn-block" data-toggle="tooltip" data-placement="top" title="<?= $rs->icon ?>">
                    <img src="<?= base_url() ?>icon_menu/<?= $rs->icon ?>" style="width:32px;"/>
                    <a href="javascript:delete_icon('<?php echo $rs->icon_id ?>')"><i class="fa fa-trash text-danger"></i></a>
                </div>
                
            </div>
<?php endforeach; ?>
    </div>
</div>
<script type="text/javascript">
    function delete_icon(Id) {
        var r = confirm("คุณแน่ใจหรือไม่ ... ?");
        if (r == true) {
            var url = "<?php echo site_url('backend/icons/delete_icon') ?>";
            var data = {id: Id};
            $.post(url, data, function (success) {
                window.location.reload();
            });
        }
    }
</script>
