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
            echo $head;
            ?>
        </h3>
    
<hr id="hr"/>
<div class="row">
	<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3" style="text-align: center;">หมายเลขบัตรประชาชน</div>
	<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
		<input type="text" name="checkcid" id="checkcid" class="form-control" maxlength="13" onKeyUp="if(this.value*1!=this.value) this.value='' ;" style="text-align:center;"/>
	</div>
	<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
		<button class="btn btn-default btn-block" onclick="CheckCID()"><i class="fa fa-check"></i> ตรวจสอบ</button>
	</div>
</div>
<hr/>
<h4 style="text-align: center;">ใบสมัคสมาชิก TO BE NUMBER ONE (รพ.สต.) ชมรม TO BE NUMBER ONE</h4>
<hr/>
<div class="row">
	<div class="col-md-2 col-lg-2"><label>หน่วยงาน</label></div>
	<div class="col-md-3 col-lg-3"><input type="text" name="office" class="form-control" value="<?php echo $office->off_name ?>" readonly="readonly"/></div>
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
		<div class="col-md-4 col-lg-4"><input type="text" name="name" id="name" class="form-control"/></div>
		<div class="col-md-2 col-lg-2"><label>นามสกุล *</label></div>
		<div class="col-md-4 col-lg-4"><input type="text" name="lname" id="lname" class="form-control"/></div>
	</div>
	<div class="row">
		<div class="col-md-2 col-lg-2"><label>เพศ *</label></div>
		<div class="col-md-4 col-lg-4">
			<input type="radio" name="sex" id="sex" value="M" /> ชาย
			<input type="radio" name="sex" id="sex" value="F" /> หญิง
		</div>
	</div>
	<div class="row">
		<div class="col-md-2 col-lg-2"><label>สถานภาพ *</label></div>
		<div class="col-md-6 col-lg-6">
			<input type="radio" name="status" id="status" value="1" /> โสด
			<input type="radio" name="status" id="status" value="2" /> สมรส
			<input type="radio" name="status" id="status" value="4" /> ม่าย/หย่าร้าง/แยกกันอยู่
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
	<div class="row">
		<div class="col-md-2 col-lg-2"><label>ที่อยู่ที่สามารถติดต่อได้ *</label></div>
		<div class="col-md-10 col-lg-10">
			<textarea id="address" class="form-control" rows="5"></textarea>
		</div>
	</div>
	<h4>การศึกษาขั้นสูงสุด</h4>
	<hr/>
	<div class="row">
		<div class="col-md-2 col-lg-2"><label>ระดับชั้น *</label></div>
		<div class="col-md-10 col-lg-10">
			<div class="row">
				<div class="col-md-6 col-lg-6"><input type="radio" name="education" id="education" value="1" /> ประถมศึกษา</div>
				<div class="col-md-6 col-lg-6"><input type="radio" name="education" id="education" value="2" /> อาชีวศึกษา</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-lg-6"><input type="radio" name="education" id="education" value="3" /> มัธยมศึกษา</div>
				<div class="col-md-6 col-lg-6"><input type="radio" name="education" id="education" value="4" /> อุดมศึกษา / ปริญญาตรี</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-lg-6"><input type="radio" name="education" id="education" value="5" /> สูงกว่าปริญญาตรี</div>
			</div>
		</div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-md-2 col-lg-2"><label>อาชีพ *</label></div>
		<div class="col-md-10 col-lg-10">
			<div class="row">
				<div class="col-md-6 col-lg-6"><input type="radio" name="occupation" id="occupation" value="1" /> รับราชการ</div>
				<div class="col-md-6 col-lg-6"><input type="radio" name="occupation" id="occupation" value="2" /> รัฐวิสาหกิจ</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-lg-6"><input type="radio" name="occupation" id="occupation" value="3" /> เกษตรกร</div>
				<div class="col-md-6 col-lg-6"><input type="radio" name="occupation" id="occupation" value="4" /> อื่น ๆ</div>
			</div>
		</div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-md-2 col-lg-2"><label>เหตุผลที่เข้าร่วมชมรม *</label></div>
		<div class="col-md-10 col-lg-10">
			<div class="row">
				<div class="col-md-12 col-lg-12">
					<input type="radio" name="reason" id="reason" value="1" /> ต้องการเข้ารับการบำบัด"ใครติดยา ยกมือขึ้น"
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-lg-12">
					<input type="radio" name="reason" id="reason" value="2" /> ต้องการร่วมรณรงค์ป้องกันและแก้ไขปัญหายาเสพติด
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-3 col-lg-3">
		<button type="button" class="btn btn-success" onclick="saveform()"><i class="fa fa-save"></i> บันทึกข้อมูล</button>
		<button type="button" class="btn btn-danger" onclick="javascript:window.location.reload()"><i class="fa fa-remove"></i> ยกเลิก</button>
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
		if(cid == ""){
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
		var occupation = $('input[name=occupation]:checked').val();
		var status = $('input[name=status]:checked').val();
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

	
		if(cid == "" || sex == null || education == null || reason == null || name == "" || lname == "" || address == "" || occupation == null || status == null){
			alert("กรอกข้อมูล * ให้ครบทุกช่อง");
			return false;
		}
		var url = "<?php echo site_url('toberegis/toberegis/saveformcompany') ?>";
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
			birth: birth,
			occupation: occupation,
			status: status
		};
		$.post(url,data,function(datas){
			alert("ลงทะเบียนเป็นสมาชิกสำเร็จ ...");
			window.location.reload();
		});
	}
</script>