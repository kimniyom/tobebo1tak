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
    array("label" => 'Dashboard',"url" => 'toberegis')
);
$active = $head;
?>

<?php echo $model->breadcrumb_backend($list, $active); ?>


<hr id="hr"/>

<h3>
<i class="fa fa-comment"></i> สมาชิก TO BE NUMBER ONE (<?php echo $type->name ?>)
</h3>

<hr id="hr"/>
<div class="well">
    <h2 style="color:red; text-align:center;">จำนวนสมาชิกทั้งหมด <?php echo number_format($countType)?> ราย</h2>
</div>
<hr/>

<hr/>
<div id="chartamphur"></div>
<hr/>
<div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-users"></i> จำนวนผู้ลงทะเบียน</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>อำเภอ</th>
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
            <td><?php echo $rs->ampurcodefull." ".$rs->ampurname ?></td>
            <td style="text-align: right;"><?php echo number_format($rs->total) ?></td>
             <td style="text-align: center;"><a href="<?php echo site_url('toberegis/tobereport/office/'.$type->id.'/'.$rs->ampurcodefull) ?>">คลิกดูข้อมูล</a></td>
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
    Highcharts.chart('chartamphur', {
        chart: {
            type: 'column'
        },
        credits:false,
        title: {
            text: 'จำนวนสมาชิก TO BE NUMBER ONE'
        },
        subtitle: {
            text: 'จังหวัดตาก'
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'จำนวน (ราย)'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'จำนวนคนลงทะเบียน: <b>{point.y:.0f} ราย</b>'
        },
        series: [{
            name: 'อำเภอ',
            colorByPoint: true,
            data: [<?php echo $chartamphur ?>],
            dataLabels: {
                enabled: true,
                rotation: -45,
                color: '#FFFFFF',
                align: 'right',
                format: '{point.y:.0f}', // one decimal
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });
</script>



