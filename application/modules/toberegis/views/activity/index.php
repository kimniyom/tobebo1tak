
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
        //array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
        //array('url' => 'backend/groupnews/index/', 'label' => "ข่าว / บทความ / เนื้อหาเว็บไซต์"),
        //array('url' => '', 'label' => 'menu2')
);

$active = $head;
$eid = $this->takmoph_libraries->url_encode($this->session->userdata('tobe_user_id'));
echo $model->breadcrumb_backend($list, $active, 'toberegis/users/detailuser/' . $eid);
?>

<div style=" clear: both;">
    <h3><i class="fa fa-newspaper-o"></i> <?php echo $head ?></h3>
    <hr/>
</div>
<div class="row">
    <div class="col-md-3 col-lg-3">
        <?php $this->load->view('toberegis/users/menu') ?> 
    </div>
    <div class="col-md-9 col-lg-9">
        <a href="<?php echo site_url('toberegis/activity/create') ?>">
            <button type="button" class="btn btn-success pull-right">
                <span class=" glyphicon glyphicon-plus"></span> <i class='fa fa-photo'></i> สร้างใหม่
            </button></a>

        <table width="100%" id="tb_mas_menu" class="table">
            <thead>
                <tr style=" background: #FFF;">
                    <th align="left" style=" display: none;">#</th>
                    <th align="left">หัวข้อ / เรื่อง</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($activity->result() as $rs):
                    $this->db->order_by("id", "ASC");
                    $rsfirst = $this->db->get_where('tobe_activity_images', array("activity_id" => $rs->id), "1")->row();
                    $use = $this->db->get_where('tobe_user', array("id" => $rs->user_id))->row();
                    ?>
                    <tr>
                        <td style=" display: none;"><?= $i++ ?></td>
                        <td align="left">
                            <div class="row">
                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                                    <?php if ($rsfirst) { ?>
                                        <img src="<?php echo base_url() ?>upload_images/tobeactivity/thumb/<?php echo $rsfirst->images ?>" class="img-responsive"/>
                                    <?php } else { ?>
                                        <?php if ($rs->qrcode) { ?>
                                            <img src="<?php echo base_url() ?>qrcode/tobeactivity/<?php echo $rs->qrcode ?>" class="img-responsive"/>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-10">
                                    <a href="<?php echo site_url('toberegis/activity/view/' . $this->takmoph_libraries->url_encode($rs->id)) ?>"><h4 style=" margin-top: 0px;"><?= $rs->title ?></h4></a>
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
    </div>
</div>

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

