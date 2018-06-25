<?php
$this->load->library('takmoph_libraries');

$model = new takmoph_libraries();
$homepage = new homepage_model();
$sub_homepage = new sub_homepage_model();
?>
<?php if ($mas_homepage->num_rows() > 0) { 
    ?>
    <div class="row" style=" margin-bottom: 10px;">
        <?php foreach ($mas_homepage->result() as $rs): 
        ?>
            <div class="<?php echo $rs->style ?>">
                <?php
                if ($rs->box_color == "#FFFFFF") {
                    $padding = "padding-left:0px; padding-right:0px;";
                } else {
                    $padding = "";
                }
                
                if(substr($rs->style,-2) == "12"){
                    $height = "";
                } else {
                    $height = "height:250px;";
                }
                ?>
                <div class="btn" style=" padding:2px 5px; font-size:20px; color:<?php echo $rs->box_color ?>; margin-bottom: 0px;margin-top:10px;background:<?php echo $rs->head_color ?>;" id="font-thaisanslite">
                    <img src="<?php echo base_url() ?>images/head-menu.png" style="width:32px;"/>
                    <?php echo $rs->title_name ?>
                </div>
                <hr style="border:<?php echo $rs->head_color ?> solid 1px; margin-top: 0px; margin-bottom: 0px;"/>
                <!-- กรณีที่เป็น folder update 2018-02-06 -->
                <div class="list-group" style="<?php echo $height ?> margin-bottom:0px; overflow:auto; border:#E0E0E0 solid 1px; background:#FFFFFF;">
                    <table class="table table-striped">
                        <tr>
                            <td>
                                <div class="row">
                                    <?php
                                    $subhomepages = $sub_homepage->get_subhomepage_group($rs->id);
                                    foreach ($subhomepages->result() as $sms):
                                        if ($sms->final == 0) :
                                            $linkMenus = site_url('homepage/viewupper/' . $this->takmoph_libraries->encode($sms->id) . '/' . $sms->id);
                                            $count = '<em style="position:absolute;right:10px;">(' . $sub_homepage->CountHomePage($sms->id) . ')</em>';
                                            ?>
                                            <div class="col-sm-6 col-md-6 col-lg-6" style=" margin-bottom: 10px;">
                                                <a href="<?php echo $linkMenus ?>"  style="text-decoration: none;border-radius:0px; border-left:none; border-right: none;">
                                                    <div class="btn btn-block" style=" position:relative; text-align: left;color:<?php echo $rs->head_color ?>;background:#FFFFFF;" id="box-group-page">
                                                        <div class="box-group-page-text"><i class="fa fa-folder"></i> <b><?php echo $sms->title ?> <?php echo $count ?></b></div>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <?php
                        $subhomepage = $sub_homepage->get_subhomepage($rs->id, $rs->limit);
                        if($subhomepage->num_rows() > 0){
                        $i = 0;
                        foreach ($subhomepage->result() as $sm):
                            if ($sm->final == 1) {
                                $i++;
                                if ($i == 1) {
                                    $img_new = '<img src="' . base_url() . 'images/icon_new.gif"/>';
                                } else {
                                    $img_new = "";
                                }
                                $linkMenu = site_url('homepage/view/' . $this->takmoph_libraries->encode($sm->id));
                                ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo $linkMenu ?>"  style="text-decoration: none;border-radius:0px; border-left:none; border-right: none;">
                                            <font style="color:red; font-size: 12px;">
                                            <i class="fa fa-calendar"></i>
                                            <?php echo $model->thaidate($sm->create_date) ?>
                                            </font>
                                            <?php echo $sm->title ?> <?php echo $img_new; ?>
                                            <img src="<?php echo base_url() ?>images/document-icon.png" style="width:24px;"/>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        endforeach;
                    } else {
                        echo "<p style='text-align:center; margin-top:20px;'>ไม่มีข้อมูล</p>";
                    }
                        ?>
                    </table>
                </div>
                <?php if ($subhomepage->result()) { ?>
                    <a href="<?php echo site_url('homepage/all/' . $this->takmoph_libraries->encode($rs->id)) ?>">
                        <button type="button" class="btn btn-xs pull-right hvr-curl-top-right" style="margin-top: 0px; background:none; color: #666666;">ทั้งหมด ...<i class="fa fa-angle-double-right"></i></button></a>
                        <?php } ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function () {
        var b_new = $("#box-group-page").width();
        var b_new_t = (b_new - 5);
        $(".box-group-page-text").css({'width': b_new_t, 'overflow': 'hidden', 'text-overflow': 'ellipsis', 'white-space': 'nowrap'});
    });
</script>

