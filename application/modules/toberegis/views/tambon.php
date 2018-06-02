<select id="tambon" class="form-control" onchange="getvillage()">
	<option value="">== ตำบล ==</option>
	<?php foreach($tambon->result() as $tam): ?>
		<option value="<?php echo $tam->tamboncodefull ?>"><?php echo $tam->tamboncodefull." ".$tam->tambonname; ?></option>
	<?php endforeach; ?>
</select>

<script type="text/javascript">
	//getvillage();
	function getvillage(village = null){
		if(village == null){
			var tamboncodefull = $("#tambon").val();
			var url = "<?php echo site_url('toberegis/toberegis/getvillage') ?>";
			var data = {tamboncodefull:tamboncodefull};
			$.post(url,data,function(datas){
				$("#_village").html(datas);
				$("#village").attr('disabled',false);
				$("#village").css({'background':'#ffffff'});
			});
		} else {
			var tamboncodefull = $("#tambon").val();
			var url = "<?php echo site_url('toberegis/toberegis/getvillage') ?>";
			var data = {tamboncodefull:tamboncodefull};
			$.post(url,data,function(datas){
				$("#_village").html(datas);
				$('#village option[value=' + village +']').attr('selected','selected');
				$("#village").attr('disabled',true);
				$("#village").css({'background':'#ffffff'});
			});
		}
	}
</script>