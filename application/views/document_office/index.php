<?php

function get_style_news($Id) {
    if ($Id == 1) {
        $icon = '<img src="' . base_url() . 'images/icon_new.gif"/>';
        $color = 'text-danger';
    } else {
        $color = 'text-success';
        $icon = "";
    }

    return array("icon" => $icon, "color" => $color);
}
?>

<div class="tabbable">

    <ul class="nav nav-tabs" id="myTab" style="margin:0px; padding:0px;">
        <li class="active"><a href="#pane1" data-toggle="tab"><i class="fa fa-bullhorn"></i> <b>ประกาศสาธารณสุขจังหวัด</b></a></li>
        <li><a href="#pane2" data-toggle="tab"><i class="fa fa-bullhorn"></i> <b>ประกาศจังหวัด</b></a></li>
    </ul>

    <div class="tab-content">
        <div id="pane1" class="tab-pane active">
            <div class="list-group">
                <?php
                $i = 0;
                foreach ($echomoph->result() as $rs1):
                    $i++;
                    $style = get_style_news($i);
                    ?>
                    <a href="http://203.157.203.22/archives/docex_img.php?DO_Id=<?= $rs1->DO_Id ?>" target="_blank" class="list-group-item">
                        <i class="fa fa-calendar <?php echo $style['color']; ?>"></i>
                        <font style="font-size:12px;" class="<?php echo $style['color']; ?>">[<?= $this->tak->thaidate($rs1->DO_Date) ?>]</font> 
                        <?php echo $style['icon']; ?>
                        <?php echo $rs1->DO_Title ?><br/>

                    </a>
                <?php endforeach; ?>
                <a href="<?php echo site_url('document_office/views/7'); ?>" class="list-group-item" style=" text-align: right;">
                    ทั้งหมด ...<i class="fa fa-angle-double-right"></i>
                </a>
            </div>
        </div>

        <div id="pane2" class="tab-pane">
            <div class="list-group">
                <?php
                $i = 0;
                foreach ($echoprovince->result() as $rs2):
                    $i++;
                    $style = get_style_news($i);
                    ?>
                    <a href="http://203.157.203.2/archives/docex_img.php?DO_Id=<?= $rs2->DO_Id ?>" target="_blank" class="list-group-item">
                        <i class="fa fa-calendar <?php echo $style['color']; ?>"></i>
                        <font style="font-size:12px;" class="<?php echo $style['color']; ?>">[<?= $this->tak->thaidate($rs2->DO_Date) ?>]</font> 
                        <?php echo $style['icon']; ?>
                        <?php echo $rs2->DO_Title ?><br/>

                    </a>
                <?php endforeach; ?>
                <a href="<?php echo site_url('document_office/views/8'); ?>" class="list-group-item" style=" text-align: right;">
                    ทั้งหมด ...<i class="fa fa-angle-double-right"></i>
                </a>
            </div>
        </div>

    </div><!-- /.tab-content -->



</div><!-- /.tabbable --></br>




<div class="tabbable">
    <ul class="nav nav-tabs" id="myTab" style="margin:0px; padding:0px;">
        <li class="active"><a href="#pane3" data-toggle="tab"><i class="fa fa-file-text-o"></i> <b>หนังสือเวียนภายใน</b></a></li>
        <li><a href="#pane4" data-toggle="tab"><i class="fa fa-file-text-o"></i> <b>หนังสือเวียนภายนอก</b></a></li>
        <li><a href="#pane5" data-toggle="tab"><i class="fa fa-file-text-o"></i> <b>ประชุม สัมนา อบรมระยะสั้น</b></a></li>
    </ul>  

    <div class="tab-content">
        <div id="pane3" class="tab-pane active">
            <div class="list-group">
                <?PHP
                $i = 0;
                foreach ($book_winding_in->result() as $rs3):
                    $i++;
                    $style = get_style_news($i);
                    ?>

                    <a href="http://203.157.203.22/archives/docex_img.php?DO_Id=<?= $rs3->DO_Id ?>" target="_blank" class="list-group-item">
                        <i class="fa fa-calendar <?php echo $style['color']; ?>"></i>
                        <font style="font-size:12px;" class="<?php echo $style['color']; ?>">[<?= $this->tak->thaidate($rs3->DO_Date) ?>]</font> 
                        <?php echo $style['icon']; ?>
                        <?php echo $rs3->DO_Title ?><br/>
                    </a>
                <?php endforeach; ?>
                <a href="<?php echo site_url('document_office/views/3'); ?>" class="list-group-item" style=" text-align: right;">
                    ทั้งหมด ...<i class="fa fa-angle-double-right"></i>
                </a>
            </div>
        </div>

        <div id="pane4" class="tab-pane">
            <div class=" list-group">
                <?PHP
                $i = 0;
                foreach ($book_winding_out->result() as $rs4):
                    $i++;
                    $style = get_style_news($i);
                    ?>
                    <a href="http://203.157.203.22/archives/docex_img.php?DO_Id=<?= $rs4->DO_Id ?>" target="_blank" class="list-group-item">
                        <i class="fa fa-calendar <?php echo $style['color']; ?>"></i>
                        <font style="font-size:12px;" class="<?php echo $style['color']; ?>">[<?= $this->tak->thaidate($rs4->DO_Date) ?>]</font> 
                        <?php echo $style['icon']; ?>
                        <?php echo $rs4->DO_Title ?><br/>
                    </a>
                <?php endforeach; ?>
                <a href="<?php echo site_url('document_office/views/4'); ?>" class="list-group-item" style=" text-align: right;">
                    ทั้งหมด ...<i class="fa fa-angle-double-right"></i>
                </a>
            </div>
        </div>
        <div id="pane5" class="tab-pane">
            <div class=" list-group">
                <?php
                $i = 0;
                foreach ($semina->result() as $semina):
                    $i++;
                    $style = get_style_news($i);
                    ?>

                    <a href="http://203.157.203.22/archives/storeex_img.php?id=<?= $semina->Store_Id ?>" target="_blank" class="list-group-item">
                        <i class="fa fa-calendar <?php echo $style['color']; ?>"></i>
                        <font style="font-size:12px;" class="<?php echo $style['color']; ?>">[<?= $this->tak->thaidate($semina->Store_Date) ?>]</font> 
                        <?php echo $style['icon']; ?>
                        <?= $semina->Store_Title ?>
                    </a>
                <?php endforeach; ?>
                <a href="<?php echo site_url('document_office/views/9'); ?>" class="list-group-item" style=" text-align: right;">
                    ทั้งหมด ...<i class="fa fa-angle-double-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
