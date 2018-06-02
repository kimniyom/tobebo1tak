<div class="well" id="box_container">
    <div class="tabbable">

        <ul class="nav nav-tabs" id="myTab" style="margin:0px; padding:0px;">
            <li class="active"><a href="#pane1" data-toggle="tab"><i class="icon-share-alt"></i> ประกาศสาธารณสุขจังหวัด</a></li>
            <li><a href="#pane3" data-toggle="tab"><i class="icon-share-alt"></i> ประกาศจังหวัด</a></li>
        </ul>
        <?php $Opentable = "<table class='table table-hover' width='724'><tbody>"; ?>
        <?php $Closetable = "</table>"; ?>

        <div class="tab-content">
            <div id="pane1" class="tab-pane active">
                <div class="alert" id="box_new">
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="new1" width="100%;">
                        <thead>
                            <tr id="tr" style="padding:0px; margin:0px; display: none;">
                                <th id="tr" width="2"></th>
                                <th id="tr"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $echo = $this->tak->get_archives('8'); // ประกาศสำนักงานสาธารณสุขจังหวัด
                            foreach ($echo->result() as $rs1):
                                ?>
                                <tr style="background:none;">
                                    <td id="td" style="color:#FFF; font-size:9px; margin:0px; padding:0px; display: none;"><?= $i++ ?></td>
                                    <td id="td">
                                        <a href="http://203.157.203.2/archives/docex_img.php?DO_Id=<?php echo $rs1->DO_Id ?>" target="_blank">
                                            <i class="icon-comment"></i>
                                            <?= $rs1->DO_Title ?><br/>
                                            <i class="icon-calendar"></i>
                                            <font style="color:#F00; font-size:12px;">วันที่ : [<?php echo $this->tak->thaidate($rs1->DO_Date) ?>]</font> 
                                            <img src="<?php echo base_url() ?>images/icon_new.gif"/>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="pane3" class="tab-pane">
                <div class="alert" id="box_new">
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="new2" width="100%;">
                        <thead>
                            <tr id="tr" style="padding:0px; margin:0px; display: none;">
                                <th id="tr" width="2" style="padding:0px; margin:0px;"></th>
                                <th id="tr"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $echo1 = $this->tak->get_archives('4'); // ประกาศจังหวัด
                            foreach ($echo1->result() as $rs3):
                                ?>
                                <tr style="background:none;">
                                    <td id="td" style="color:#FFF; font-size:9px; margin:0px; padding:0px; display: none;"><?= $i++ ?></td>
                                    <td id="td">
                                        <a href="http://203.157.203.2/archives/docex_img.php?DO_Id=<?php echo $rs3->DO_Id ?>" target="_blank">
                                            <i class="icon-comment"></i>
                                            <?php echo $rs3->DO_Title ?><br/>
                                            <i class="icon-calendar"></i>
                                            <font style="color:#F00; font-size:12px;">วันที่ : [<?php echo $this->tak->thaidate($rs3->DO_Date) ?>]</font> 
                                            <img src="<?php echo base_url() ?>images/icon_new.gif"/>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div><!-- /.tab-content -->



    </div><!-- /.tabbable --></br>
</div><!-- End BG -->

<div align="center"><img src="<?php echo base_url() ?>images/section-shadow.png" width="700" height="22" /></div>

<div id="box_container" class="well">
    <div class="tabbable">
        <ul class="nav nav-tabs" id="myTab" style="margin:0px; padding:0px;">
            <li class="active"><a href="#pane4" data-toggle="tab"><i class="icon-share-alt"></i> หนังสือเวียนภายใน</a></li>
            <li><a href="#pane5" data-toggle="tab"><i class="icon-share-alt"></i> หนังสือเวียนภายนอก</a></li>
            <li><a href="#pane6" data-toggle="tab"><i class="icon-share-alt"></i> ประชุม สัมนา อบรมระยะสั้น</a></li>
        </ul>  

        <div class="tab-content">
            <div id="pane4" class="tab-pane active">
                <div class="alert" id="box_new">
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="new3" width="100%;">
                        <thead>
                            <tr id="tr" style="padding:0px; margin:0px; display: none;">
                                <th id="tr" width="2" style="padding:0px; margin:0px;"></th>
                                <th id="tr"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $echoin = $this->tak->get_archives('1');
                            foreach ($echoin->result() as $rs4):
                                ?>
                                <tr style="background:none;">
                                    <td id="td" style="color:#FFF; font-size:9px; margin:0px; padding:0px; display: none;"><?= $i++ ?></td>
                                    <td id="td">
                                        <a href="http://203.157.203.2/archives/docex_img.php?DO_Id=<?php echo $rs4->DO_Id ?>" target="_blank">
                                            <i class="icon-comment"></i>
                                            <?= $rs4->DO_Title ?><br/>
                                            <i class="icon-calendar"></i>
                                            <font style="color:#F00; font-size:12px;">วันที่ : [<?php echo $this->tak->thaidate($rs4->DO_Date) ?>]</font> 
                                            <img src="<?php echo base_url() ?>images/icon_new.gif"/>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="pane5" class="tab-pane">
                <div class="alert" id="box_new">
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="new4" width="100%;">
                        <thead>
                            <tr id="tr" style="padding:0px; margin:0px; display: none;">
                                <th id="tr" width="2" style="padding:0px; margin:0px;"></th>
                                <th id="tr"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $echo_out = $this->tak->get_archives('6');
                            foreach ($echo_out->result() as $rs5):
                                ?>
                                <tr style="background:none;">
                                    <td id="td" style="color:#FFF; font-size:9px; margin:0px; padding:0px; display: none;"><?= $i++ ?></td>
                                    <td id="td">
                                        <a href="http://203.157.203.2/archives/docex_img.php?DO_Id=<?php echo $rs5->DO_Id ?>" target="_blank">
                                            <i class="icon-comment"></i>
                                            <?= $rs5->DO_Title ?><br/>
                                            <i class="icon-calendar"></i>
                                            <font style="color:#F00; font-size:12px;">วันที่ : [<?php echo $this->tak->thaidate($rs5->DO_Date) ?>]</font> 
                                            <img src="<?php echo base_url() ?>images/icon_new.gif"/>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="pane6" class="tab-pane">
                <div class="alert" id="box_new">
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="new5" width="100%;">
                        <thead>
                            <tr id="tr" style="padding:0px; margin:0px; display: none;">
                                <th id="tr" width="2" style="padding:0px; margin:0px;"></th>
                                <th id="tr"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $get_semina = $this->tak->get_semina();
                            foreach ($get_semina->result() as $semina):
                                ?>
                                <tr style="background:none;">
                                    <td id="td" style="color:#FFF; font-size:9px; margin:0px; padding:0px; display: none;"><?= $i++ ?></td>
                                    <td id="td">
                                        <a href="http://203.157.203.2/archives/storeex_img.php?id=<?php echo $semina->Store_Id ?>" target="_blank">
                                            <i class="icon-comment"></i>
                                            <?= $semina->Store_Title ?><br/>
                                            <i class="icon-calendar"></i>
                                            <font style="color:#F00; font-size:12px;">วันที่ : [<?= $this->tak->thaidate($semina->Store_Date) ?>]</font> 
                                            <img src="<?php echo base_url() ?>images/icon_new.gif"/>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.tab-content -->

    </div><!-- /.tabbable -->

</div>
