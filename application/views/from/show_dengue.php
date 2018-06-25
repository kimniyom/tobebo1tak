
<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#tb_mas_menu').dataTable({
            "bJQueryUI": false,
            //"sPaginationType" : "full_numbers",// แสดงตัวแบ่งหน้า
            "bLengthChange": false, // แสดงจำนวน record ที่จะแสดงในตาราง
            "iDisplayLength": 20, // กำหนดค่า default ของจำนวน record 
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

<!-- Dialog Insert News -->
<div id="container">
    <h1 id="h1">รายงานสถานการณ์ไข้เลือดออก</h1>
    <div id="body" style="text-align:center;">
        <table width="100%" id="tb_mas_menu">
            <thead>
                <tr>
                    <th align="left">#</th>
                    <th align="left">หัวข้อ</th>
                    <th align="left">ไฟล์</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $dengue = $this->tak->get_dengue();
                $i = 1;
                foreach ($dengue->result() as $rs):
                    ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td align="left"><a href="<?= base_url() ?>file_download/<?= $rs->file ?>" target="_blank"><?= $rs->title ?></a></td>
                        <td align="left"><a href="<?= base_url() ?>file_download/<?= $rs->file ?>" target="_blank"><img src="<?= base_url() ?>icon_menu/download-icon.png"/><?= $rs->file ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <p class="footer">&nbsp;</p>
</div>
