
<select id="link" class="form-control">
    <option value="">เลือกเมนู</option>
    <?php foreach ($masmenu->result() as $rs): ?>
        <option value="<?php echo $rs->admin_menu_id; ?>"><?php echo $rs->admin_menu_name; ?></option>
    <?php endforeach; ?>
</select>
