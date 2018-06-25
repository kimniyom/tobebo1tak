<div class="form-group">
    <label class="sr-only" for="exampleInputAmount">เพิ่มสีพื้นหลัง</label>
    <div class="input-group">
        <div class="input-group-addon">เพิ่มสี</div>
        <input type="color" class="form-control" id="color" placeholder="Amount">
        <div class="input-group-addon btn btn-default" onclick="add_color()"><i class="fa fa-save text-success"></i> บันทึกสีที่เลือก</div>
    </div>
</div>

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
                        <div class="img-responsive img-polaroid" style="height:150px; background: <?php echo $rs->color ?>"></div>
                    </div>
                </figure>
                <div id="btn-card">
                    <button type="button" class="btn btn-default btn-sm" onclick="select_bg('<?php echo $rs->id ?>', '<?php echo $rs->color ?>')">
                        <i class="fa fa-check text-success"></i> ใช้งาน</button>
                    <button type="button" class="btn btn-default btn-sm" onclick="delete_bg_color('<?php echo $rs->id ?>')">
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

    function add_color() {
        var url = "<?php echo site_url('backend/background/add_color') ?>";
        var color = $("#color").val();
        var data = {color: color};
        if (color == '') {
            swal("แจ้งเตือน", "คุณยังไม่ได้เลือกสี", "warning");
            return false;
        }
        $.post(url, data, function (success) {
            get_color();
        });
    }

    function delete_bg_color(id) {
        var r = confirm("คุณแน่ใจหรือไม่ ... ?");
        if (r == true) {
            var url = "<?php echo site_url('backend/background/delete_color') ?>";
            var id = id;
            var data = {id: id};
            $.post(url, data, function (success) {
                swal({title: "Success", text: "ลบข้อมูลแล้ว ...", type: "success",
                    showCancelButton: false,
                    loseOnConfirm: true,
                    showLoaderOnConfirm: false},
                        function () {
                            get_color();
                        });
            });
        }
    }

    function set_bg_color(id) {
        var url = "<?php echo site_url('backend/background/set_bg_color') ?>";
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
