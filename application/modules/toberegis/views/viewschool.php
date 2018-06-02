<style type="text/css">
	.row{
		margin-bottom: 10px;
	}
</style>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = array(
    array('url' => 'toberegis/toberegis', 'label' => 'Dashboard')
);
$active = $head;
?>
<?php echo $model->breadcrumb($list, $active); ?>

        <h3 id="head_submenu">
            <i class="fa fa-file-text-o fa-2x text-warning"></i>
            <?php
            echo "(".$row->name." ".$row->lname.")";
            ?>
        </h3>
    
<hr id="hr"/>

<h4 style="text-align: center;">ใบสมัคสมาชิก TO BE NUMBER ONE (นักเรียน / นักศึกษา) ชมรม TO BE NUMBER ONE</h4>
<hr/>
<div class="row">
	<div class="col-md-2 col-lg-2"><label>สถานศึกษา</label></div>
	<div class="col-md-3 col-lg-3"><input type="text" name="office" class="form-control" value="<?php echo $office->name ?>" readonly="readonly"/></div>
	<div class="col-md-2 col-lg-2"><label>จังหวัด</label></div>
	<div class="col-md-3 col-lg-3"><input type="text" name="province" class="form-control" value="ตาก" readonly="readonly"/></div>
</div>
<hr/>
<div id="form-register">
<div class="well">
	<h4>ประวัติส่วนตัวสมาชิก</h4>
	<hr/>
	<div class="row">
		<div class="col-md-2 col-lg-2"><label>ชื่อ *</label></div>
		<div class="col-md-4 col-lg-4">
			<input type="text" name="name" id="name" class="form-control" value="<?php echo $row->name ?>"/>
		</div>
		<div class="col-md-2 col-lg-2"><label>นามสกุล *</label></div>
		<div class="col-md-4 col-lg-4">
			<input type="text" name="lname" id="lname" class="form-control" value="<?php echo $row->lname ?>"/>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2 col-lg-2"><label>เพศ *</label></div>
		<div class="col-md-4 col-lg-4">
			<input type="radio" name="sex" id="sex" value="M" <?php echo ($row->sex == "M") ? "checked" : ""; ?>/> ชาย
			<input type="radio" name="sex" id="sex" value="F" <?php echo ($row->sex == "F") ? "checked" : ""; ?>/> หญิง
		</div>
	</div>

	<div class="row">
		<div class="col-md-2 col-lg-2"><label>วันเกิด *</label></div>
		<div class="col-md-2 col-lg-2">
			<select class="form-control" id="day">
				<?php for($i=1;$i<=31;$i++){ 
					if(strlen($i) < 2){
						$day = "0".$i;
					} else {
						$day = $i;
					}
				?>
				<option value="<?php echo $day ?>" <?php echo (substr($row->birth,-2) == $day) ? "selected" : ""; ?>><?php echo $day ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-2 col-lg-2">

			<select class="form-control" id="month">
				<?php 
				$resultmonth = $this->db->get("mas_month");
				foreach($resultmonth->result() as $m){ 
				?>
				<option value="<?php echo $m->month_val ?>" <?php echo (substr($row->birth,5,2) == $m->month_val) ? "selected" : ""; ?>><?php echo $m->month_th ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-2 col-lg-2">
			<select class="form-control" id="year">
				<?php 
				$year = date("Y");
				for($y=$year;$y>=($year-80);$y--) { ?>
					<option value="<?php echo $y ?>" <?php echo (substr($row->birth,0,4) == $y) ? "selected" : ""; ?>><?php echo ($y+543) ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2 col-lg-2"><label>ที่อยู่ที่สามารถติดต่อได้ *</label></div>
		<div class="col-md-10 col-lg-10">
			<textarea id="address" class="form-control" rows="5"><?php echo $row->address ?></textarea>
		</div>
	</div>

	<h4>ระดับการศึกษา</h4>
	<hr/>
	<div class="row">
		<div class="col-md-2 col-lg-2"><label>ระดับชั้น *</label></div>
		<div class="col-md-10 col-lg-10">
		<div class="row">
						<div class="col-md-6 col-lg-6">
							<input type="radio" name="education" id="education" value="1" <?php echo ($row->education == "1") ? "checked" : ""; ?>/> ประถมศึกษา</div>
						<div class="col-md-6 col-lg-6">
							<input type="radio" name="education" id="education" value="2" <?php echo ($row->education == "2") ? "checked" : ""; ?>/> อาชีวศึกษา</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-lg-6">
							<input type="radio" name="education" id="education" value="3" <?php echo ($row->education == "3") ? "checked" : ""; ?>/> มัธยมศึกษา</div>
						<div class="col-md-6 col-lg-6">
							<input type="radio" name="education" id="education" value="4" <?php echo ($row->education == "4") ? "checked" : ""; ?>/> อุดมศึกษา / ปริญญาตรี</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-lg-6"><input type="radio" name="education" id="education" value="5" <?php echo ($row->education == "5") ? "checked" : ""; ?>/> สูงกว่าปริญญาตรี</div>
					</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2 col-lg-2"><label>เหตุผลที่เข้าร่วมชมรม *</label></div>
		<div class="col-md-10 col-lg-10">
<div class="row">
				<div class="col-md-12 col-lg-12">
					<input type="radio" name="reason" id="reason" value="1" <?php echo ($row->reason == "1") ? "checked" : ""; ?>/> ต้องการเข้ารับการบำบัด"ใครติดยา ยกมือขึ้น"
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-lg-12">
					<input type="radio" name="reason" id="reason" value="2" <?php echo ($row->reason == "2") ? "checked" : ""; ?>/> ต้องการร่วมรณรงค์ป้องกันและแก้ไขปัญหายาเสพติด
				</div>
			</div>
		</div>
	</div>
</div>


</div>
<script type="text/javascript">
	disabledform();
	function CheckCID(){
		var url = "<?php echo site_url('toberegis/toberegis/checkcid') ?>";
		var cid = $("#checkcid").val();
		var type = "<?php echo $type ?>";
		var amphur = "<?php echo $amphur ?>";
		var office = "<?php echo $office_id ?>";
		if(cid == "" || cid.length != "13"){
			alert("กรอกข้อมูลไม่ครบ");
			return false;
		}
		var data = {cid: cid,type: type,amphur: amphur,office: office};
		$.post(url,data,function(datas){
			if(datas == "1"){
				alert("ขออภัยท่านเคยลงทะเบียนแล้ว");
				disabledform();
				return false;
			} else {
				enabledform();
			}
		});
	}

	function disabledform(){
		$("#name").attr('disabled',true);
		$("#name").css({'background':'#eeeeee'});
		$("#lname").attr('disabled',true);
		$("#lname").css({'background':'#eeeeee'});
		$("#address").attr('disabled',true);
		$("#address").css({'background':'#eeeeee'});
		$("#day").attr('disabled',true);
		$("#day").css({'background':'#eeeeee'});
		$("#month").attr('disabled',true);
		$("#month").css({'background':'#eeeeee'});
		$("#year").attr('disabled',true);
		$("#year").css({'background':'#eeeeee'});
		$('input[type="radio"]').attr('disabled',true);
		$('input[type="radio"]').css({'background':'#eeeeee'});
	}

	function enabledform(){
		$("#name").prop('disabled',false);
		$("#name").css({'background':'#ffffff'});
		$("#lname").prop('disabled',false);
		$("#lname").css({'background':'#ffffff'});
		$("#address").prop('disabled',false);
		$("#address").css({'background':'#ffffff'});
		$("#day").prop('disabled',false);
		$("#day").css({'background':'#ffffff'});
		$("#month").prop('disabled',false);
		$("#month").css({'background':'#ffffff'});
		$("#year").prop('disabled',false);
		$("#year").css({'background':'#ffffff'});
		$('input[type="radio"]').prop('disabled',false);
		$('input[type="radio"]').css({'background':'#ffffff'});
		//var selValue = $('input[name=rbnNumber]:checked').val();
	}

	function saveform(){
		var sex = $('input[name=sex]:checked').val();
		var education = $('input[name=education]:checked').val();
		var reason = $('input[name=reason]:checked').val();
		var name = $("#name").val();
		var lname = $("#lname").val();
		var address = $("#address").val();
		var type = "<?php echo $type ?>";
		var amphur = "<?php echo $amphur ?>";
		var office = "<?php echo $office_id ?>";
		var cid = $("#checkcid").val();
		var day = $("#day").val();
		var month = $("#month").val();
		var year = $("#year").val();
		var birth = (year + "-" + month + "-" + day);
	
		if(cid == "" || sex == null || education == null || reason == null || name == "" || lname == "" || address == ""){
			alert("กรอกข้อมูล * ให้ครบทุกช่อง");
			return false;
		}
		var url = "<?php echo site_url('toberegis/toberegis/saveformschool') ?>";
		var data = {
			cid: cid,
			sex: sex,
			education: education,
			reason: reason,
			name: name,
			lname: lname,
			address: address,
			type: type,
			amphur: amphur,
			office: office,
			birth: birth
		};
		$.post(url,data,function(datas){
			alert("ลงทะเบียนเป็นสมาชิกสำเร็จ ...");
			window.location.reload();
		});
	}
</script>
</script>