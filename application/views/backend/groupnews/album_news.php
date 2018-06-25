<script type="text/javascript">
    function delete_img_album(id,images) {
        var url = "<?php echo site_url('backend/news/delete_images_news') ?>";
        var data = {id: id,images: images};
        $.post(url, data, function (result) {
            show_album_news();
        });
    }
</script>

<div class="row">
    <?php
    foreach ($images->result() as $rs) {
        ?>
        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
            <div class="container-card" style="max-height:250px;">
                <div class="img-wrapper">
                    <img src="<?php echo base_url() ?>upload_images/news/<?php echo $rs->images; ?>" class="img-responsive img-polaroid" style="height:250px;"/>
                </div>
                <a href="javascript:delete_img_album('<?php echo $rs->id ?>','<?php echo $rs->images?>')">
                    <button type="button" class="btn btn-danger btn-sm" id="btn-card"><i class="fa fa-trash"></i></button>
                </a>
            </div>
        </div>

    <?php } ?>
</div>
