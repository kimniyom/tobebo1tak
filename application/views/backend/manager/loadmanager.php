<div class="row">
	<?php foreach($datas->result() as $rs): ?>
		<div class="col-md-3 col-lg-3">
			<?php echo $rs->images ?>
		</div>
	<?php endforeach; ?>
</div>