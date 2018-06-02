<select id="ampur" class="form-control" onchange="gettambon()">
	<option value="">== อำเภอ ==</option>
	<?php foreach($ampur->result() as $am): ?>
		<option value="<?php echo $am->ampurcodefull ?>"><?php echo $am->ampurcodefull." ".$am->ampurname; ?></option>
	<?php endforeach; ?>
</select>

<script type="text/javascript">
	//gettambon(tambon);
	function gettambon(tambon = null,village = null){
		if(tambon == null){
			var ampurcodefull = $("#ampur").val();
			var url = "<?php echo site_url('toberegis/toberegis/gettambon') ?>";
			var data = {ampurcodefull:ampurcodefull};
			$.post(url,data,function(datas){
				$("#_tambon").html(datas);
				$("#tambon").attr('disabled',false);
				$("#tambon").css({'background':'#ffffff'});
			});
		} else {
			var ampurcodefull = $("#ampur").val();
			var url = "<?php echo site_url('toberegis/toberegis/gettambon') ?>";
			var data = {ampurcodefull:ampurcodefull};
			$.post(url,data,function(datas){
				$("#_tambon").html(datas);
				$('#tambon option[value=' + tambon +']').attr('selected','selected');
				$("#tambon").attr('disabled',true);
				$("#tambon").css({'background':'#ffffff'});
				getvillage(village);
			});
		}
	}
</script>