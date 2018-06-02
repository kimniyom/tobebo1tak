<select id="ampur" class="form-control" onchange="gettambon()">
	<option value="">== อำเภอ ==</option>
	<?php foreach($ampur->result() as $am): ?>
		<option value="<?php echo $am->ampurcodefull ?>"><?php echo $am->ampurcodefull." ".$am->ampurname; ?></option>
	<?php endforeach; ?>
</select>

<script type="text/javascript">
	gettambon();
	function gettambon(){
		var ampurcodefull = $("#ampur").val();
		var url = "<?php echo site_url('toberegis/toberegis/gettambon') ?>";
		var data = {ampurcodefull:ampurcodefull};
		$.post(url,data,function(datas){
			$("#_tambon").html(datas);
		});
	}
</script>