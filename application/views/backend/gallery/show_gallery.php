<button type="button" class="btn btn-default pull-right"
        onclick="delete_all('<?php echo $album_id ?>')"><i class="fa fa-trash text-danger"></i> Delete All</button>
<br/><br/>
<hr/>
<div class="row">
    <?php
    $i = 0;
    foreach ($gallery->result() as $rs): $i++;
        ?>
        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
            <div class="container-card" style="height:250px;">
                <div class="img-wrapper">
                    <?php if (!empty($rs->images)) { ?>
                        <img src="<?php echo base_url() ?>upload_images/photo/<?php echo $rs->images; ?>" class="img-responsive img-polaroid" style="height:200px;"/>
                    <?php } else { ?>
                        <center>
                            <img src="<?php echo base_url() ?>upload_images/photo/no-sign_1334604348.png" class="img-responsive img_news"/>
                        </center>
                    <?php } ?>
                </div>

                <div id="btn-card">
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
            var url = "<?php echo site_url('backend/photo/delete_images') ?>";
            var data = {id: Id};
            $.post(url, data, function (success) {
                $("#log").append("<font style='color:red;'>Delete Images " + success + " Success </font><br/>");
                loaddata();
            });
        }
    }
</script>

<script type="text/javascript">
    function delete_all() {
        var r = confirm("คุณแน่ใจหรือไม่ ... ?");
        if (r == true) {
            var url = "<?php echo site_url('backend/photo/delete_images_all') ?>";
            var id = "<?php echo $album_id ?>";
            var data = {album_id: id};
            $.post(url, data, function (success) {
                swal({title: "Success", text: "ลบข้อมูลแล้ว ...", type: "success",
                    showCancelButton: false,
                    loseOnConfirm: true,
                    showLoaderOnConfirm: false},
                        function () {
                            //swal("Success","แก้ไขข้อมูลแล้ว ...","success");
                            loaddata();
                        });
            });
        }
    }
</script>
