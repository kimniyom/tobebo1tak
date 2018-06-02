<style type="text/css">
	.row{
		margin-bottom: 10px;
	}
</style>
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
if($upper != "0"){
     $label = array('url' => 'toberegis/occupation/index/0', 'label' => 'อาชีพ,สถานบริการ,หน่วยงาน,โรงเรียน');
} else {
    $label = array('url' => '', 'label' => '');;
}
$list = array(
    array('url' => 'toberegis/toberegis', 'label' => 'Dashboard'),
    $label
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
<a href="<?php echo site_url('toberegis/occupation/create/'.$upper) ?>">
<button type="button" class="btn btn-default"><i class='fa fa-plus'></i> เพิ่ม</button></a>
<table class="table">
	<thead>
     <tr>
         <th>#</th>
         <th>Name</th>
         <th>Upper</th>
         <th>Final</th>
         <th></th>
     </tr>   
    </thead>
    <tbody>
        <?php $i=0;foreach($occupation->result() as $rs): $i++;?>
        <tr>
            <td><?php echo $i ?></td>
            <td>
                <?php if($rs->final != "1") {?>
                    <a href="<?php echo site_url('toberegis/occupation/index/'.$rs->id) ?>"><?php echo $rs->name ?></a>
                <?php } else { ?>
                    <?php echo $rs->name ?>
                <?php } ?>
                </td>
            <td><?php echo $rs->upper ?></td>
            <td><?php echo $rs->final ?></td>
            <td>
                <i class="fa fa-pencil"></i>
                <i class="fa fa-tranch"></i>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>