<style type="text/css">
	.row{
		margin-bottom: 10px;
	}

	#form-register label{
		color:red;
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
<center>
	<img src="<?php echo base_url() ?>/assets/module/toberegis/images/logotak.png" style="height:100px;"/>
</center>
<h4 style="text-align: center;">สมาชิกชมรม TO BE NUMBER ONE</h4>
<!--
<div class="row">
	<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3" style="text-align: center;">หมายเลขบัตรประชาชน</div>
	<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
		<input type="text" name="checkcid" id="checkcid" class="form-control" maxlength="13" onKeyUp="if(this.value*1!=this.value) this.value='' ;" style="text-align:center;"/>
	</div>
	<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
		<button class="btn btn-default btn-block" onclick="CheckCID()"><i class="fa fa-check"></i> ตรวจสอบ</button>
	</div>
</div>
-->
<hr/>
<div id="form-register">
<div class="wells">
	<h4>ประวัติส่วนตัวสมาชิก</h4>
	<hr/>
	<div class="row">
		<div class="col-md-2 col-lg-2"><label>ชื่อ *</label></div>
		<div class="col-md-4 col-lg-4"><input type="text" name="name" id="name" class="form-control" value="<?php echo $datas->name ?>" /></div>
		<div class="col-md-2 col-lg-2"><label>นามสกุล *</label></div>
		<div class="col-md-4 col-lg-4"><input type="text" name="lname" id="lname" class="form-control" value="<?php echo $datas->lname ?>"/></div>
	</div>
	<div class="row">
		<div class="col-md-2 col-lg-2"><label>เพศ *</label></div>
		<div class="col-md-4 col-lg-4">
			<input type="radio" name="sex" id="sex" value="M" <?php echo ($datas->sex == "M") ? "checked" : "";?>/> ชาย
			<input type="radio" name="sex" id="sex" value="F" <?php echo ($datas->sex == "F") ? "checked" : "";?>/> หญิง
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
				<option value="<?php echo $day ?>" <?php echo (substr($datas->birth,-2) == $day) ? "selected" : "";?>><?php echo $day ?></option>
				<?php } ?>
			</select>
		</div>

		<div class="col-md-2 col-lg-2">
			<select class="form-control" id="month">
				<?php 
				$resultmonth = $this->db->get("mas_month");
				foreach($resultmonth->result() as $m){ 
				?>
				<option value="<?php echo $m->month_val ?>" <?php echo (substr($datas->birth,5,2) == $m->month_val) ? "selected" : "";?>><?php echo $m->month_th ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-2 col-lg-2">
			<select class="form-control" id="year">
				<?php 
				$year = date("Y");
				for($y=$year;$y>=($year-80);$y--) { ?>
					<option value="<?php echo $y ?>" <?php echo (substr($datas->birth,0,4) == $y) ? "selected" : "";?>><?php echo ($y+543) ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2 col-lg-2"><label>ที่อยู่ที่สามารถติดต่อได้ *</label></div>
		<div class="col-md-10 col-lg-10">
			<div class="row">
				<div class="col-md-12 col-lg-6">
					<input type="text" class="form-control" name="address" id="address" placeholder="เลขที่ ... ซอย ...ถนน.." value="<?php echo $datas->address ?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-md-3 col-lg-3">
					จังหวัด
					<select id="changwat" class="form-control" onchange="getampur(this.value)">
						<option value="">== จังหวัด ==</option>
						<?php foreach($changwat->result() as $changwars): ?>
							<option value="<?php echo $changwars->changwatcode ?>" <?php echo ($changwars->changwatcode == $datas->changwat) ? "selected" : "";?>><?php echo $changwars->changwatname; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-3 col-lg-3">
					อำเภอ
					<div id="_ampur"></div>
				</div>
				<div class="col-md-3 col-lg-3">
					ตำบล
					<div id="_tambon"></div>
				</div>
				<div class="col-md-3 col-lg-3">
					หมู่บ้าน
					<div id="_village"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2 col-lg-2"><label>อาชีพ *</label></div>
		<div class="col-md-4 col-lg-4">
			<select id="occupation" class="form-control" onchange="getfilter(this.value,1)">
				<option value="">== เลือกอาชีพ ==</option>
				<?php foreach($occupation->result() as $occ): ?>
					<option value="<?php echo $occ->id ?>" <?php echo ($occ->id == $datas->occupation) ? "selected" : "";?>><?php echo ($occ->code) ? $occ->code." ".$occ->name : $occ->name; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2 col-lg-2">
		</div>
			<div class="col-md-6 col-lg-6">
			<div id="boxlv2">
				<?php if($level2) { ?>
					<input type="text" disabled="disabled" class="form-control" value="<?php echo $level2 ?>">
				<?php } ?>
			</div>
			
		</div>
		
			<div class="col-md-4 col-lg-4">
			<div id="boxlv3">
				<?php if($level3) { ?>
					<input type="text" disabled="disabled" class="form-control"> value="<?php echo $level3 ?>">
				<?php } ?>
			</div>
			<?php if($datas->classroom) { ?>
				<input type="text" name="classroom" id="classroom" class='form-control' value="<?php echo $datas->classroom ?>" disabled="disabled"/>
			<?php } ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2 col-lg-2"><label>ระดับการศึกษาสูงสุด *</label></div>
		<div class="col-md-10 col-lg-10">
			<div class="row">
				<?php foreach($education->result() as $edu): ?>
				<div class="col-md-12 col-lg-12">
					<input type="radio" name="education" id="education" value="<?php echo $edu->id ?>" <?php echo ($edu->id == $datas->education) ? "checked" : "";?>/> 
					<?php echo $edu->educationname ?>
				</div>
			<?php endforeach; ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-2 col-lg-2"><label>พฤติกรรมการดื่มเครื่องดื่มที่มีแอลกอฮอล์ *</label></div>
		<div class="col-md-10 col-lg-10">
			<div class="row">
				<?php foreach($alcohol->result() as $lgh): ?>
				<div class="col-md-12 col-lg-12">
					<input type="radio" name="alcohol" id="alcohol" value="<?php echo $lgh->id ?>" <?php echo ($lgh->id == $datas->alcohol) ? "checked" : "";?>/> 
					<?php echo $lgh->alcohol ?>
				</div>
			<?php endforeach; ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-2 col-lg-2"><label>พฤติกรรมการสูบบุหรี่ *</label></div>
		<div class="col-md-10 col-lg-10">
			<div class="row">
				<?php foreach($smoking->result() as $sk): ?>
				<div class="col-md-12 col-lg-12">
					<input type="radio" name="smoking" id="smoking" value="<?php echo $sk->id ?>" <?php echo ($sk->id == $datas->smoking) ? "checked" : "";?>/> 
					<?php echo $sk->smoking ?>
				</div>
			<?php endforeach; ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-2 col-lg-2"><label>เหตุผลที่เข้าร่วมชมรม *</label></div>
		<div class="col-md-10 col-lg-10">
			<div class="row">
				<div class="col-md-12 col-lg-12">
					<input type="radio" name="reason" id="reason" value="1" <?php echo ($datas->reason == 1) ? "checked" : "";?>/> ต้องการเข้ารับการบำบัด"ใครติดยา ยกมือขึ้น"
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-lg-12">
					<input type="radio" name="reason" id="reason" value="2"  <?php echo ($datas->reason == 2) ? "checked" : "";?>/> ต้องการร่วมรณรงค์ป้องกันและแก้ไขปัญหายาเสพติด
				</div>
			</div>
		</div>
	</div>
</div>
<hr/>
<div class="row">
	<div class="col-md-2 col-lg-2"><label>วันที่เป็นสมาชิก</label></div>
	<div class="col-md-10 col-lg-10"><?php echo $datas->d_update ?></div>
</div>

<!--
<div class="row">
	<div class="col-md-3 col-lg-3">
		<button type="button" class="btn btn-success" onclick="saveform()"><i class="fa fa-save"></i> บันทึกข้อมูล</button>
		<button type="button" class="btn btn-danger" onclick="javascript:window.location.reload()"><i class="fa fa-remove"></i> ยกเลิก</button>
	</div>
</div>
-->
</div>
<script type="text/javascript">
	disabledform();
	getampur();
	function CheckCID(){
		var url = "<?php echo site_url('toberegis/toberegis/checkcid') ?>";
		var cid = $("#checkcid").val();
		if(cid == "" || cid.length != "13"){
			alert("กรอกข้อมูลไม่ครบ");
			return false;
		}
		var data = {cid: cid};
		$.post(url,data,function(datas){
			if(datas == "1"){
				alert("ขออภัยท่านเคยลงทะเบียนแล้ว");
				disabledform();
				getampur();
				return false;
			} else {
				enabledform();
				getampur();
			}
		});
	}

	function disabledform(){
		$("#name").attr('disabled',true);
		$("#name").css({'background':'#ffffff'});
		$("#lname").attr('disabled',true);
		$("#lname").css({'background':'#ffffff'});
		$("#address").attr('disabled',true);
		$("#address").css({'background':'#ffffff'});
		$("#day").attr('disabled',true);
		$("#day").css({'background':'#ffffff'});
		$("#month").attr('disabled',true);
		$("#month").css({'background':'#ffffff'});
		$("#year").attr('disabled',true);
		$("#year").css({'background':'#ffffff'});
		$('input[type="radio"]').attr('disabled',true);
		$('input[type="radio"]').css({'background':'#ffffff'});
		$("#changwat").attr('disabled',true);
		$("#changwat").css({'background':'#ffffff'});
		$("#ampur").attr('disabled',true);
		$("#ampur").css({'background':'#ffffff'});
		$("#tambon").attr('disabled',true);
		$("#tambon").css({'background':'#ffffff'});
		$("#village").attr('disabled',true);
		$("#village").css({'background':'#ffffff'});
		$("#occupation").attr('disabled',true);
		$("#occupation").css({'background':'#ffffff'});
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
		$("#changwat").attr('disabled',false);
		$("#changwat").css({'background':'#ffffff'});
		$("#ampur").attr('disabled',false);
		$("#ampur").css({'background':'#ffffff'});
		$("#tambon").attr('disabled',false);
		$("#tambon").css({'background':'#ffffff'});
		$("#village").attr('disabled',false);
		$("#village").css({'background':'#ffffff'});
		$("#occupation").attr('disabled',false);
		$("#occupation").css({'background':'#ffffff'});
	}

	function saveform(){
		var occupation = $("#occupation").val();
		var classroom;
		var lv2;
		var lv3;

		if(occupation == 1){
			classroom = $("#classroom").val();
			if(classroom == ""){
				alert("ตรวจสอบข้อมูลอาชีพให้ครบถูกต้อง");
				return false;
			} else {
				lv2 = $("#lv2").val();
				lv3 = "";
				classroom = $("#classroom").val();
			}
		} else if(occupation == 3){
			if($("#lv2").val() == ""){
				alert("ตรวจสอบข้อมูลอาชีพให้ครบถูกต้อง");
				return false;
			} else {
				lv2 = $("#lv2").val();
				lv3 = "";
				classroom = "";
			}
		} else if(occupation == 4){
			if($("#lv2").val() == "" || $("#lv3").val() == ""){
				alert("ตรวจสอบข้อมูลอาชีพให้ครบถูกต้อง");
				return false;
			} else {
				lv2 = $("#lv2").val();
				lv3 = $("#lv3").val();
				classroom = "";
			}
		}
		
		var sex = $('input[name=sex]:checked').val();
		var education = $('input[name=education]:checked').val();
		var smoking = $('input[name=smoking]:checked').val();
		var alcohol = $('input[name=alcohol]:checked').val();
		var reason = $('input[name=reason]:checked').val();
		var name = $("#name").val();
		var lname = $("#lname").val();
		var address = $("#address").val();
		var changwat = $("#changwat").val();
		var ampur = $("#ampur").val();
		var tambon = $("#tambon").val();
		var village = $("#village").val();
		var cid = $("#checkcid").val();
		var day = $("#day").val();
		var month = $("#month").val();
		var year = $("#year").val();
		var birth = (year + "-" + month + "-" + day);
	
		if(cid == "" || sex == null || education == null || reason == null || name == "" || lname == "" || changwat == "" || ampur == "" || tambon == "" || village == "" || smoking == null || alcohol == null){
			alert("กรอกข้อมูล * ให้ครบทุกช่อง");
			return false;
		}
		var url = "<?php echo site_url('toberegis/toberegis/save') ?>";
		var data = {
			cid: cid,
			sex: sex,
			education: education,
			occupation: occupation,
			classroom: classroom,
			reason: reason,
			name: name,
			lname: lname,
			address: address,
			changwat: changwat,
			ampur: ampur,
			tambon: tambon,
			village: village,
			birth: birth,
			alcohol: alcohol,
			smoking: smoking,
			lv2: lv2,
			lv3: lv3
		};
		$.post(url,data,function(datas){
			//alert("ลงทะเบียนเป็นสมาชิกสำเร็จ ...");
			window.location="<?php echo site_url('toberegis/toberegis/success') ?>";
		});
	}

	function getfilter(id,level){
			if(level == 1){
				$("#boxlv2").html("");
				$("#boxlv3").html("");
			};
			var occupation = $("#occupation").val();
			if(occupation == 1 && level == 2){
				$("#classroom").show();
			} else {
				$("#classroom").hide();
			}
			var url = "<?php echo site_url('toberegis/occupation/filter') ?>";
			var data = {id:id,level: level};
			var levels = (level + 1);
			$.post(url,data,function(datas){ 
				$("#boxlv" + levels).html(datas);
				//var str = html(datas);
				//if(datas != 0){
					//$("#filter").append(datas);
				//}
			});
	}

	function getampur(){
		var changwatcode = $("#changwat").val();
		var url = "<?php echo site_url('toberegis/toberegis/getampur') ?>";
		var data = {changwatcode:changwatcode};
		$.post(url,data,function(datas){
			$("#_ampur").html(datas);
			$('#ampur option[value=<?php echo $datas->ampur ?>]').attr('selected','selected');
			$("#ampur").attr('disabled',true);
			$("#ampur").css({'background':'#ffffff'});
			gettambon(<?php echo $datas->tambon ?>,<?php echo $datas->village ?>);
		});
	}

	function setlevel(){
		var url = "<?php echo site_url('toberegis/occupation/getlevel') ?>";
		var occupation = $("#occupation").val();
		var data = {id: occupation};
		$.post(url,data,function(datas){ 
				alert(datas);
		});
	}

</script>