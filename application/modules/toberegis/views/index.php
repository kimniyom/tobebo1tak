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
<h3><i class="fa fa-comment"></i> สมาชิก TO BE NUMBER ONE</h3>

<hr id="hr"/>
<div class="well">
    <h2 style="color:red; text-align:center;">จำนวนสมาชิกทั้งหมด <?php echo number_format($countall)?> ราย</h2>
</div>
<hr/>
<div class="row">
    <div class="col-md-8 col-lg-8">
        <div id="charttype"></div>
    </div>
    <div class="col-md-4 col-lg-4">
        <?php foreach ($ReportType->result() as $rs) { ?>

            <div class="row">
                <div class="col-md-3 col-lg-3 col-sm-5 col-xs-12" style="text-align:center;">
                    <center>
                        <img src="<?php echo base_url() ?>assets/module/toberegis/images/<?php echo $rs->icons ?>" class="img img-responsive" style="margin-top:10px;"/>
                    </center>
                </div>
                <div class="col-md-9 col-lg-9 col-sm-7 col-xs-12" style=" margin-bottom: 10px;">
                    <a href="<?php echo site_url('toberegis/tobereport/index/' . $rs->id) ?>" style=" text-decoration: none;">
                        <div class="btn btn-default btn-block" id="btn-category">
                            <h4><?php echo $rs->typename ?></h4>
                            <hr/>
                            <span class="badge">จำนวน <?php echo $rs->total ?> ราย</span>
                        </div></a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<hr/>
<div id="chartamphur"></div>
<!--
<div class="row">
<?php //foreach ($amphur->result() as $am) { ?>
        <div class="col-md-4 col-lg-3" style=" margin-bottom: 10px;">
            <a href="<?php //echo site_url('toberegis/toberegis/index/' . $am->distid) ?>" style=" text-decoration: none;">
                <div class="btn btn-default btn-block" id="btn-category">
                    <h4><?php //echo $am->distname ?></h4>
                    <span class="badge">จำนวน 0 ราย</span>
                </div></a>
            
                <div class="row" style="margin:0px;">
                    <div class="col-md-4 col-lg-4" style="padding:0px;">
                        <button type="button" class="btn btn-default btn-block">Left</button>
                    </div>
                    <div class="col-md-4 col-lg-4" style="padding:0px;">
                        <button type="button" class="btn btn-default btn-block">Middle</button>
                    </div>
                    <div class="col-md-4 col-lg-4" style="padding:0px;">
                        <button type="button" class="btn btn-default btn-block">Right</button>
                    </div>
                </div>
           
        </div>
<?php //} ?>
</div>
-->
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

Highcharts.chart('charttype', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    credits: false,
    title: {
        text: 'ร้อยละการลงทะเบียนแต่ละประเภท'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'ร้อยละ',
        colorByPoint: true,
        data: [<?php echo $charttype ?>]
    }]
});
</script>



