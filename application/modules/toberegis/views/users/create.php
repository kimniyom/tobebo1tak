<style type="text/css">
    .row{
        margin-bottom: 10px;
    }
</style>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = array(
    //array("label" => 'Dashboard',"url" => 'toberegis')
);
$active = $head;
?>

<?php echo $model->breadcrumb_backend($list, $active); ?>
<hr id="hr"/>
<h3><i class="fa fa-user"></i> ผู้ใช้งาน</h3>
<hr/>
<div class="row">
	<div class="col-md-2 col-lg-2">ชื่อ</div>
	<div class="col-md-5 col-lg-4">
		<input type="text" name="name" id="name" class="form-control">
	</div>
</div>
<div class="row">
	<div class="col-md-2 col-lg-2">นามสกุล</div>
	<div class="col-md-5 col-lg-4">
		<input type="text" name="lname" id="lname" class="form-control">
	</div>
</div>
<div class="row">
	<div class="col-md-2 col-lg-2">สิทธิ์การใช้งาน</div>
	<div class="col-md-2 col-lg-2">
		<select class="form-control" id="type">
			<option value="">== เลือกสถานะ ==</option>
			<?php foreach($type->result() as $types): ?>
				<option value="<?php echo $types->id ?>"><?php echo $types->type ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<!--
<div class="row">
	<div class="col-md-2 col-lg-2">อำเภอ</div>
	<div class="col-md-5 col-lg-4">
		<select class="form-control" id="ampur">
			<?php //foreach($ampur->result() as $am): ?>
				<option value="<?php //echo $am->ampurcodefull ?>"><?php //echo $am->ampurname ?></option>
			<?php //endforeach; ?>
		</select>
	</div>
</div>
-->
<hr/>
<div class="row">
	<div class="col-md-2 col-lg-2">Username</div>
	<div class="col-md-5 col-lg-4">
		<input type="text" name="username" id="username" class="form-control">
	</div>
</div>
<div class="row">
	<div class="col-md-2 col-lg-2">Password</div>
	<div class="col-md-5 col-lg-4">
		<input type="password" name="password" id="password" class="form-control">
	</div>
</div>

<hr/>
<div class="row">
	<div class="col-md-2 col-lg-2"></div>
	<div class="col-md-10 col-lg-10">
		<button type="button" class="btn btn-success" onclick="saveuser()"><i class="fa fa-save"></i> บันทึกข้อมูล</button>
		<button type="button" class="btn btn-danger" onclick="javascript:window.location.reload();"><i class="fa fa-remove"></i> ยกเลิก</button>
	</div>
</div>

<script type="text/javascript">
	function saveuser(){
		var url = "<?php echo site_url('toberegis/users/saveuser') ?>";
		var name = $("#name").val();
		var lname = $("#lname").val();
		var username = $("#username").val();
		var password = $("#password").val();
		var type = $("#type").val();
		if(name == "" || lname == "" || username == "" || password == "" || type == ""){
			alert("กรอกข้อมูลไม่ครบ...");
			return false;
		}
		var data = {
			name: name,
			lname: lname,
			username: username,
			password: MD5(password),
			type: type
		};
		$.post(url,data,function(datas){
			var id = datas.id;
			window.location="<?php echo site_url('toberegis/users/detailuser') ?>" + "/" + id;
		},'json');
	}
</script>


