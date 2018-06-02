<style type="text/css">
    #btn-category{
        background: #f1f1f1;
        color: #686868;
        border:#f1f1f1  solid 1px;
    }

    #btn-category:hover{
        background: #f8f8f8;
        border: #dfdfdf solid 1px;
    }

    .row{
        margin-bottom: 10px;
    }
</style>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = array(
    array("label" => 'Dashboard',"url" => 'toberegis'),
    array("label" => 'รายอำเภอ',"url" => 'toberegis/tobereport/index/'.$type->id),
    array("label" => $type->typename,"url" => 'toberegis/tobereport/office/'.$type->id.'/'.$amphur->distid)
);
$active = $head;
?>

<?php echo $model->breadcrumb_backend($list, $active); ?>

<h3>
    <img src="<?php echo base_url() ?>assets/module/toberegis/images/<?php echo $type->icons ?>"  style="margin-top:0px; height:64px;"/>
    <i class="fa fa-comment"></i> สมาชิก (<?php echo $type->typename ?>)
</h3>

<hr id="hr"/>
<div class="panel panel-default" style="margin-bottom: 0px;">
    <div class="panel-heading"><i class="fa fa-users"></i> จำนวนผู้ลงทะเบียน</div>
    
<table class="table" id="tb-office">
    <thead>
        <tr>
            <th>ชื่อ - สกุล</th>
            <th>เพศ</th>
            <th>อายุ</th>
            <th>วันที่ลงทะเบียน</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach($table->result() as $rs): 
            ?>
        <tr>
            <td><?php echo $rs->name." ".$rs->lname ?></td>
            <td><?php echo ($rs->sex == 'M') ? "ชาย" : "หญิง";?></td>
            <td><?php echo $model-
            >GetAge($rs->birth) ?></td>
            <td><?php echo $rs->d_update ?></td>
            <td>
                <a href="<?php echo site_url('toberegis/toberegis/view/'.$rs->id) ?>"><i class="fa fa-eye"></i></a> 
                <!--
                <a href="<?php //echo site_url('toberegis/toberegis/update/'.$rs->id) ?>"><i class="fa fa-pencil"></i></a>
                <a href=""><i class="fa fa-trash"></i></a>
            -->
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    
</table>

</div>

<script type="text/javascript">
    $(document).ready(function(){
        var width = window.innerWidth;
        var height = window.innerHeight;
        var h;

        if(width >= 768 && height > 500){
            h = height - 519;
         } else {
            h = false;
         }
        $("#tb-office").DataTable({
            "scrollY": h,
            "scrollX": true,
            //"scrollCollapse": true,
            "paging": false
        });
    });
</script>


