<select id="tambon" class="form-control" onchange="getvillage()">
	<option value="">== ตำบล ==</option>
	<?php foreach($tambon->result() as $tam): ?>
		<option value="<?php echo $tam->tamboncodefull ?>"><?php echo $tam->tamboncodefull." ".$tam->tambonname; ?></option>
	<?php endforeach; ?>
</select>

<script type="text/javascript">
	getvillage();
	function getvillage(){
		var tamboncodefull = $("#tambon").val();
		var url = "<?php echo site_url('toberegis/toberegis/getvillage') ?>";
		var data = {tamboncodefull:tamboncodefull};
		$.post(url,data,function(datas){
			$("#_village").html(datas);
		});
	}
</script>