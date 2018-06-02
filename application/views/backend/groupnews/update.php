
<?php $path = base_url() . "assets/CK-Editor/"; ?>

<input type="hidden" id="_group_id" name="_group_id" value="<?= $groupnews->id ?>"/>
<label>ชื่อกลุ่ม</label>
<input type="text" id="_groupname" name="_groupname" style="width:98%;" class="form-control input-mini" required="required" value="<?= $groupnews->groupname ?>"/>
<br/>
<label>สีหัวข้อ</label>
<input type="color" id="_headcolor" value="<?php echo $groupnews->headcolor?>"/>
<label>สีพื้นหลัง</label>
<input type="color" id="_background" value="<?php echo $groupnews->background?>"/>
<br/>
<label>จำนวน Column</label>
<select id="_column" class="form-control">
    <option value="3" <?php if($groupnews->column == 3){ echo "selected";}?>>4</option>
    <option value="12" <?php if($groupnews->column == 12){ echo "selected";}?>>1</option>
    <option value="6" <?php if($groupnews->column == 6){ echo "selected";}?>>2</option>
    <option value="4" <?php if($groupnews->column == 4){ echo "selected";}?>>3</option>
</select>

<script type="text/javascript">
    function edit_groupnews() {

        var data = {
            id: $("#_group_id").val(),
            groupname: $("#_groupname").val(),
            headcolor: $("#_headcolor").val(),
            background: $("#_background").val(),
            column: $("#_column").val()
        };

        $.ajax({
            type: "POST",
            url: "<?= site_url('backend/groupnews/save_update') ?>",
            data: data,
            success: function () {
                window.location.reload();
            }
        });
    }

</script>