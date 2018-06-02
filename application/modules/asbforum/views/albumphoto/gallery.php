
<hr/>
รูปภาพของคุณ
<button type="button" class="btn btn-default btn-sm"
        onclick="delete_all()"><i class="fa fa-trash text-danger"></i> ลบทั้งหมด</button>
<div class="row">
    <?php
    $i = 0;
    foreach ($images->result() as $rs): $i++;
        ?>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2">
            <div class="container-card" style="height:150px;">
                <div class="img-wrapper">
                    <?php if (!empty($rs->images)) { ?>
                        <img src="<?php echo base_url() ?>assets/module/asbforum/albumphoto/<?php echo $rs->images; ?>" class="img-responsive img-polaroid" style="height:100px;"/>
                    <?php } else { ?>
                        <center>
                            <img src="<?php echo base_url() ?>upload_images/photo/no-sign_1334604348.png" class="img-responsive img_news"/>
                        </center>
                    <?php } ?>
                </div>

                <div id="btn-card">

                    <button type="button" class="btn btn-default btn-sm"
                            onclick="Addcontent('<?php echo $rs->images ?>')">
                        <i class="fa fa-image text-success"></i> เลือก</button>
                    <button type="button" class="btn btn-default btn-sm"
                            onclick="delete_images('<?php echo $rs->id ?>')">
                        <i class="fa fa-remove text-danger"></i> ลบ</button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

</div>

<script type="text/javascript">
    function delete_images(Id) {
        var r = confirm("คุณแน่ใจหรือไม่ ... ?");
        if (r == true) {
            var url = "<?php echo site_url('asbforum/albumphoto/delete_images') ?>";
            var data = {id: Id};
            $.post(url, data, function (success) {
                loadimages();
            });
        }
    }
</script>

<script type="text/javascript">
    function delete_all() {
        var r = confirm("คุณแน่ใจหรือไม่ ... ?");
        if (r == true) {
            var url = "<?php echo site_url('asbforum/albumphoto/delete_images_all') ?>";
            var data = {};
            $.post(url, data, function (success) {
                swal({title: "Success", text: "ลบข้อมูลแล้ว ...", type: "success",
                    showCancelButton: false,
                    loseOnConfirm: true,
                    showLoaderOnConfirm: false},
                        function () {
                            //swal("Success","แก้ไขข้อมูลแล้ว ...","success");
                            loadimages();
                        });
            });
        }
    }
</script>