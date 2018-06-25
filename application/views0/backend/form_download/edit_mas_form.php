<label>เรื่อง</label>
<input type="text"  class="form-control" id="mas_form_edit" value="<?php echo $model->mas_from ?>"/>

<script type="text/javascript">
    function save_edit_mas_form() {
        var url = "<?= site_url('backend/form_download/save_edit_mas_form') ?>";
        var mas_from = $("#mas_form_edit").val();
        var id = "<?php echo $model->id ?>";
        var data = {
            id: id,
            mas_from: mas_from
        };

        $.post(url, data,
                function (success) {
                    window.location.reload();
                });// Endpost
    }
</script>