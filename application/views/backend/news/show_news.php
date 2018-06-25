
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
    array('url' => 'backend/groupnews/index/', 'label' => "ข่าว / บทความ / เนื้อหาเว็บไซต์"),
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
<a href="<?php echo site_url('backend/news/create/' . $groupnews->id) ?>">
    <button type="button" class="btn btn-success pull-right">
        <span class=" glyphicon glyphicon-plus"></span> เพิ่มเนื้อหา
    </button></a>

<table width="100%" id="tb_mas_menu" class="table">
    <thead>
        <tr style=" background: #FFF;">
            <th align="left" style=" display: none;">#</th>
            <th align="left">หัวข้อ</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($news->result() as $rs):
            $this->db->order_by("id", "ASC");
            $rsfirst = $this->db->get_where('images_news', array("new_id" => $rs->id), "1")->row();
            $use = $this->db->get_where('mas_user', array("user_id" => $rs->user_id))->row();
            ?>
            <tr>
                <td style=" display: none;"><?= $i++ ?></td>
                <td align="left">
                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                            <?php if ($rsfirst) { ?>
                                <img src="<?php echo base_url() ?>upload_images/news/thumb/<?php echo $rsfirst->images ?>" class="img-responsive"/>
                            <?php } else { ?>
                                <?php if ($rs->qrcode) { ?>
                                    <img src="<?php echo base_url() ?>qrcode/<?php echo $rs->qrcode ?>" class="img-responsive"/>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-10">
                            <a href="<?php echo site_url('backend/news/view/' . $rs->id) ?>"><h4 style=" margin-top: 0px;"><?= $rs->titel ?></h4></a>
                            <?php echo $model->thaidate($rs->date) ?>
                            <hr/>
                            <i class="fa fa-user"></i> <?php echo $use->name . " " . $use->lname ?>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {

        $('#tb_mas_menu').dataTable({
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

    });
</script>

