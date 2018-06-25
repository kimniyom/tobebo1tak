
<div class="row">
    <?php
    $i = 0;
    foreach ($themes->result() as $rs): $i++;
        ?>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
            <center>
                <p><?php echo $rs->template ?></p>
            </center>
            <a class="hover14">
                <div class="container-card" style="height:400px;">
                    <figure>
                        <div class="img-wrapper">
                            <img src="<?php echo base_url() ?>themes/<?php echo $rs->template ?>/images/ex.jpg" class="img-responsive img-polaroid" style="height:400px;"/>
                        </div>
                    </figure>
                    <div id="btn-card">
                        <?php if ($rs->active == '0') { ?>
                            <button type="button" class="btn btn-default btn-sm" 
                                    onclick="set_template('<?php echo $rs->id ?>')">
                                <i class="fa fa-image text-success"></i> ใช้ Template นี้</button>
                            <button type="button" class="btn btn-default btn-sm" onclick="delete_template('<?php echo $rs->id   ?>')">
                                <i class="fa fa-trash text-danger"></i> ลบ</button>
                        <?php } else { ?>
                            <div class="btn btn-danger disabled">ถูกใช้เป็น Template ปัจจุบัน</div>
                        <?php } ?>
                    </div>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>



<!--
  ####### Inser Update Delete ##########
-->

<script type="text/javascript">
    function delete_template(id) {
        var r = confirm("คุณแน่ใจหรือไม่ ... ?");
        if (r == true) {
            var url = "<?php echo site_url('backend/template/delete_directory') ?>";
            var id = id;
            var data = {id: id};
            $.post(url, data, function (success) {
              
                swal({title: "Success", text: "ลบข้อมูลแล้ว ...", type: "success",
                    showCancelButton: false,
                    loseOnConfirm: true,
                    showLoaderOnConfirm: false},
                        function () {
                            window.location.reload();
                        });
                        
            });
        }
    }

    function set_template(id) {
        var url = "<?php echo site_url('backend/template/set_template') ?>";
        var id = id;
        var data = {id: id};
        $.post(url, data, function (success) {
            swal({title: "Success", text: "ตั้งค่า Template สำเร็จ ...", type: "success",
                showCancelButton: false,
                loseOnConfirm: true,
                showLoaderOnConfirm: false},
                    function () {
                        window.location.reload();
                    });
        });
    }
</script>
