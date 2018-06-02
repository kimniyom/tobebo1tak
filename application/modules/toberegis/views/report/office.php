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
    array("label" => 'รายอำเภอ',"url" => 'toberegis/tobereport/index/'.$type->id)
);
$active = $head;
?>

<?php echo $model->breadcrumb_backend($list, $active); ?>

<h3>
    <img src="<?php echo base_url() ?>assets/module/toberegis/images/<?php echo $type->icons ?>"  style="margin-top:0px; height:64px;"/>
    <i class="fa fa-comment"></i> สมาชิก TO BE NUMBER ONE (<?php echo $type->typename ?>)
</h3>

<hr id="hr"/>
<div class="well" style="margin-bottom: 0px;">
    <h2 style="color:red; text-align:center;">จำนวนสมาชิก อำเภอ(<?php echo $amphur->distname ?>) <?php echo number_format($countType) ?> ราย</h2>
</div>
<div class="panel panel-default" style="margin-bottom: 0px;">
    <div class="panel-heading"><i class="fa fa-users"></i> จำนวนผู้ลงทะเบียน</div>
<table class="table" id="tb-office">
    <thead>
        <tr>
            <th><?php echo $type->typename ?></th>
            <th style="text-align: right;">จำนวน</th>
            <th style="text-align: center;"></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $sum = 0;
        foreach($table->result() as $rs): 
            $sum = ($sum + $rs->total);
            ?>
        <tr>
            <td><?php echo $rs->code." ".$rs->name ?></td>
            <td style="text-align: right;"><?php echo number_format($rs->total) ?></td>
             <td style="text-align: center;"><a href="<?php echo site_url('toberegis/tobereport/viewlist/'.$type->id.'/'.$amphur->distid.'/'.$rs->code) ?>">คลิกดูรายชื่อ</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
             <th style="text-align:center;">รวม</th>
            <th style="text-align:right;"><?php echo number_format($sum) ?></th>
        </tr>
    </tfoot>
</table>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var width = window.innerWidth;
        var height = window.innerHeight;
        var h;

        if(width >= 768 && height > 500){
            h = height - 665;
         } else {
            h = false;
         }
        $("#tb-office").dataTable({
            "scrollY": h,
            "scrollCollapse": true,
            "paging": false
        });
    });
</script>


