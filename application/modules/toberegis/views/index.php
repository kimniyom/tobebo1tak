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
        <hr/>
        <div id="chartamphur"></div>
    </div>
    <div class="col-md-4 col-lg-4">
        <?php 
        $sum = 0;
        foreach ($ReportType->result() as $rs) { ?>
            <?php if($rs->id != '3'){ 
                $sum = $sum + $rs->total;
                ?>
            <div class="row">
                <div class="col-md-9 col-lg-9 col-sm-7 col-xs-12 " style=" margin-bottom: 10px;">
                    <a href="<?php echo site_url('toberegis/tobereport/index/' . $rs->id) ?>" style=" text-decoration: none;">
                        <div class="btn btn-default btn-block">
                            <h4><?php echo $rs->typename ?></h4>  
                        </div></a>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-5 col-xs-12" style="text-align:center; padding-top: 0px;">
                    จำนวน
                   <h4><?php echo $rs->total ?></h4>
                </div>
            </div>
            <?php } else if($rs->id == '3'){ ?>
                <div class="row">
                <div class="col-md-9 col-lg-9 col-sm-7 col-xs-12 " style=" margin-bottom: 10px;">
                    <a href="<?php echo site_url('toberegis/tobereport/index/' . $rs->id) ?>" style=" text-decoration: none;">
                        <div class="btn btn-default btn-block">
                            <h4><?php echo $rs->typename ?></h4>  
                        </div></a>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-5 col-xs-12" style="text-align:center; padding-top: 0px;">
                    จำนวน
                   <h4><?php echo $sum ?></h4>
                </div>
            </div>
            <?php } ?>
        <?php } ?>
        <hr/>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">เหตุผลที่เข้าร่วมชมรม</div>
                    <div class="panel-body" style=" padding: 0px;">
                        <div class="list-group" style="border-radius:0px; margin: 0px;">
                            <div class="list-group-item" style="border-radius:0px;">
                                ต้องการเข้ารับการบำบัด"ใครติดยา ยกมือขึ้น" 
                                <span class="badge"><?php echo $reason->reason1 ?></span>
                            </div>
                            <div class="list-group-item" style="border-radius:0px;">
                                ต้องการร่วมรณรงค์ป้องกันและแก้ไขปัญหายาเสพติด 
                                <span class="badge"><?php echo $reason->reason2 ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-4 col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">สูบบุหรี่</div>
            <div class="panel-body">
                <div class="row">
                <?php foreach($smoking->result() as $sk): ?>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style=" text-align: center;">
                        <span class="badge"><?php echo number_format($sk->total) ?></span>
                        <div style=" width: 100%; border-bottom: solid 1px #eeeeee; height: 10px;"></div>
                        <?php echo $sk->smoking ?> 
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">ดื่มแอลกอฮอล์</div>
            <div class="panel-body">
                <div class="row">
                <?php foreach($alcohol->result() as $al): ?>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style=" text-align: center;">
                        <span class="badge"><?php echo number_format($al->total) ?></span>
                        <div style=" width: 100%; border-bottom: solid 1px #eeeeee; height: 10px;"></div>
                        <?php echo $al->alcohol ?> 
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
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



