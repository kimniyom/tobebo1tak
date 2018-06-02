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
        $("#add_new").click(function () {
            $("#box-add-news").modal();
        });
    });
</script>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        var table = $('#tb_mas_menu').dataTable({
            //"sPaginationType" : "full_numbers",// แสดงตัวแบ่งหน้า
            "bLengthChange": false, // แสดงจำนวน record ที่จะแสดงในตาราง
            "iDisplayLength": 15, // กำหนดค่า default ของจำนวน record 
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
        /*
         new $.fn.dataTable.FixedHeader(table, {
         "offsetTop": 50
         });
         */
    });
</script>

<script type="text/javascript">

    function add_new() {
        //var detail = $("#detailnews").Editor("getText");
        var detail = CKEDITOR.instances.detailnews.getData();
        if (detail == "") {
            alert("กรอกรายละเอียด ...?");
            return false;
        }
        var data = {
            groupnews: $("#groupID").val(),
            new_id: $("#new_id").val(),
            title: $("#title").val(),
            detail: detail
        };
        $.ajax({
            type: "POST",
            url: "<?= site_url('backend/news/save_news') ?>",
            data: data,
            success: function () {
                window.location.reload();
            }
        });
    }


    function set_from(id) {
        var url = "<?php echo site_url('backend/news/from_edit_news') ?>";
        var data = {id: id};
        $.post(url, data, function (datas) {
            $("#box-edit-news").modal();
            $("#from-edit").html(datas);
        });
    }

    function upload_images_new() {

    }

    function delete_news_flag(news_id) {
        var url = "<?php echo site_url('backend/news/delete_news_flag'); ?>";
        var data = {news_id: news_id};

        $.post(url, data, function (success) {
            alert("รอการอนุมัติ ...");
            window.location.reload();
        });
    }

    function delete_news(news_id) {
        var url = "<?php echo site_url('backend/news/delete_news'); ?>";
        var data = {news_id: news_id};

        $.post(url, data, function (success) {
            window.location.reload();
        });
    }
</script>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
    array('url' => 'backend/groupnews/index/', 'label' => "กลุ่มข่าวประชาสัมพันธ์"),
        //array('url' => '', 'label' => 'menu2')
);

$active = $groupnews->groupname;
echo $model->breadcrumb_backend($list, $active);
?>

<br/>
<!-- Dialog Insert News -->

<input type="hidden" id="groupID" value="<?php echo $groupnews->id ?>"/>

<h3><i class="fa fa-newspaper-o"></i> <?= $groupnews->groupname ?></h3>
<hr/>
<button type="button" class="btn btn-success pull-right" id="add_new">
    <span class=" glyphicon glyphicon-plus"></span> เพิ่มข่าวประชาสัมพันธ์
</button>

<table width="100%" id="tb_mas_menu" class="table">
    <thead>
        <tr style=" background: #FFF;">
            <th align="left" style=" width: 5%;">#</th>
            <th align="left" style=" width: 5%;">รหัส</th>
            <th align="left">หัวข้อ</th>
            <?php if ($this->session->userdata['status'] == "S") { ?>
                <th>FlagDelete</th>
                <th>ขอลบข่าวโดย</th>
            <?php } ?>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($news->result() as $rs):
            ?>
            <tr>
                <td><?= $i++ ?></td>
                <td align="left"><?= $rs->id ?></td>
                <td align="left"><?= $rs->titel ?></td>

                <?php if ($this->session->userdata['status'] == "S") { ?>
                    <td>
                        <?= $rs->flag_delete ?>
                        <?php if ($rs->flag_delete == '1') { ?>
                            <div class="btn btn-default btn-sm" onclick="delete_news('<?php echo $rs->id ?>');">
                                <i class=" glyphicon glyphicon-trash"></i>
                                ยืนยันการลบ</div>
                        <?php } ?>
                    </td>
                    <td><?= $rs->flag_delete_user; ?></td>
                <?php } ?>

                <td style=" width: 10%;">
                    <?php if ($rs->flag_delete == '1') { ?>
                        <p style="color:red;">ข่าวโดนลบ</p>
                    <?php } else { ?>
                        <div class="btn-group" style=" text-align:left;">
                            <a class="btn dropdown-toggle btn-default btn-sm" data-toggle="dropdown">
                                <span class=" glyphicon glyphicon-cog"></span> จัดการ <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('backend/news/from_upload_images_news/' . $rs->id . '/' . $groupnews->id); ?>">
                                        <span class=" glyphicon glyphicon-picture"></span> รูปภาพ</a>
                                </li>
                                <li>
                                    <a href="Javascript:void(0);" 
                                       onclick="set_from('<?php echo $rs->id; ?>');">
                                        <span class=" glyphicon glyphicon-edit"></span> แก้ไข</a>
                                </li>
                                <li>
                                    <a href="Javascript:void(0);"  
                                       onclick="delete_news_flag('<?= $rs->id ?>');">
                                        <span class=" glyphicon glyphicon-trash"></span> ลบ</a></li>
                            </ul>
                        </div>
                    <?php } ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- 
    Add Edit Delete 
-->

<div id="box-add-news" class="modal fade  bs-example-modal-lg" data-backdrop="static">
    <div class="modal-dialog modal-lg" style=" width: 99%;">
        <div class="modal-content">
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
                    <textarea id="detailnews" name="detailnews" class="form-control" rows="3"></textarea> 
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-success" value="บันทึกข้อมูล" onclick="add_new()"/>
                    <input type="reset" class="btn btn-danger" value="ยกเลิก" />
                </div>
            </form>
        </div>
    </div>
</div>

<div id="box-edit-news" class="modal fade  bs-example-modal-lg" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">แก้ไขข่าว</h3>
            </div>
            <div class="modal-body">
                <div id="from-edit"></div>
            </div>
        </div>
    </div>
</div>


