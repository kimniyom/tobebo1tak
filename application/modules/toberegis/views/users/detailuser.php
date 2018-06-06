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
	<div class="col-md-3 col-lg-3">
		<div class="list-group">
			<div class="list-group-item">ชื่อ - สกุล: <?php echo $user->name." ".$user->lname ?></div>
			<div class="list-group-item">สถานะ: <?php echo $type->type ?></div>
			<div class="list-group-item">ลงทะเบียน: <?php echo $user->d_update ?></div>
		</div>
	</div>
	<div class="col-md-9 col-lg-9">
		<?php echo $filter ?>
	</div>
</div>