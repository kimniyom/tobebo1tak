<select id="village" class="form-control">
	<option value="">== หมู่บ้าน ==</option>
	<?php foreach($village->result() as $vill): ?>
		<option value="<?php echo $vill->villagecodefull ?>"><?php echo $vill->villagecodefull." ".$vill->villagename; ?></option>
	<?php endforeach; ?>
</select>

