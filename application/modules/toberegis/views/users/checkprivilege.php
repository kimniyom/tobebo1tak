<style type="text/css">
	.row{
		margin-bottom: 10px;
	}
</style>
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = array(
    //array('url' => 'toberegis/toberegis', 'label' => 'Dashboard')
);
$active = $head;
?>
<?php echo $model->breadcrumb($list, $active); ?>

        <h3 id="head_submenu">
            <i class="fa fa-file-text-o fa-2x text-warning"></i>
            <?php
            echo $head;
            ?>
        </h3>
    
<hr id="hr"/>
<div class="row">
	<div class="col-md-2 col-lg-2"><label>เลขบัตรประชาชน 13 หลัก</label></div>
	<div class="col-md-3 col-lg-3">
		<input type="text" name="cid" id="cid" class="form-control" maxlength="13" />
	</div>
</div>
	<div class="row">
		<div class="col-md-2 col-lg-2"><label>วัน/เดือน/ปี เกิด </label></div>
		<div class="col-md-2 col-lg-1">
			<select class="form-control" id="day">
				<?php for($i=1;$i<=31;$i++){ 
					if(strlen($i) < 2){
						$day = "0".$i;
					} else {
						$day = $i;
					}
				?>
				<option value="<?php echo $day ?>"><?php echo $day ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-2 col-lg-2">
			<select class="form-control" id="month">
				<?php 
				$resultmonth = $this->db->get("mas_month");
				foreach($resultmonth->result() as $m){ 
				?>
				<option value="<?php echo $m->month_val ?>"><?php echo $m->month_th ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-2 col-lg-2">
			<select class="form-control" id="year">
				<?php 
				$year = date("Y");
				for($y=$year;$y>=($year-80);$y--) { ?>
					<option value="<?php echo $y ?>"><?php echo ($y+543) ?></option>
				<?php } ?>
			</select>
		</div>
	</div>

	<hr/>
<div class="row">

	<div class="col-md-2 col-lg-2"></div>
	<div class="col-md-3 col-lg-3">
		<button type="button" class="btn btn-success" onclick="Checkprivilege()">ตรวจสอบข้อมูล</button>
	</div>
</div>

<div id="error"></div>

<script type="text/javascript">
	function Checkprivilege(){
		var url = "<?php echo site_url('toberegis/users/checkprivileges') ?>";
		var cid = $("#cid").val();
		var day = $("#day").val();
		var month = $("#month").val();
		var year = $("#year").val();
		var birth = (year + "-" + month + "-" + day);
		var data = {cid: cid,birth: birth};
		$.post(url,data,function(datas){
			if(datas == 1){
 				var url = "<?php echo site_url('toberegis/users/view') ?>";
 				window.location=url;
			} else {
				$("#error").html("<hr/><p style='color:red;'>!ไม่พบข้อมูล</p>");
				return false;
			}
		});
	}
</script>
	