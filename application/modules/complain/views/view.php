<script type="text/javascript">
    $(document).ready(function () {
        $("#complain").dataTable({
            "bJQueryUI": false,
            //"sPaginationType" : "full_numbers",// แสดงตัวแบ่งหน้า
            "bLengthChange": false, // แสดงจำนวน record ที่จะแสดงในตาราง
            "iDisplayLength": 10, // กำหนดค่า default ของจำนวน record 
            //"sScrollY": "100px",
            "bFilter": true, // แสดง search box
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

<p style="font-size: 25px; font-weight: normal; margin-bottom: 15px;"><?php echo $head; ?></p>
<table class="table table-striped" style="border: #cccccc solid 1px;" id="complain">
    <thead>
        <tr>
            <th>หัวข้อผู้ร้องเรียน</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($complain->result() as $rs):
            ?>
            <tr>
                <td>
                    <?php echo $rs->head_complain; ?><br/>
                    <p style="font-size: 12px; color: #ff0000;">
                        ผู้ร้องเรียน : <?php echo $rs->name; ?> เวลา <?php echo $rs->d_update; ?>
                        <a href="<?php echo site_url('complain/detail/' . $rs->id); ?>">  
                            <font style=" float: right;"><i class="icon icon-list"></i> รายละเอียด</font>
                        </a>
                    </p>

                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>