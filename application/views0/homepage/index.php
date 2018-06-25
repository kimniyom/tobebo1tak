<?php
$this->load->library('takmoph_libraries');

$model = new takmoph_libraries();
$homepage = new homepage_model();
$sub_homepage = new sub_homepage_model();
?>

<div class="row" style=" margin-bottom: 10px;">
    <?php foreach ($mas_homepage->result() as $rs): ?>
        <div class="<?php echo $rs->style ?>">
            <?php
            if ($rs->box_color == "#FFFFFF") {
                $padding = "padding-left:0px; padding-right:0px;";
            } else {
                $padding = "";
            }
            ?>


            <div class="btn" style=" padding:2px 5px; font-size:20px; color:<?php echo $rs->box_color ?>; margin-bottom: 0px;margin-top:10px;background:<?php echo $rs->head_color ?>;" id="font-thaisanslite">
                <img src="<?php echo base_url() ?>images/head-menu.png" style="width:32px;"/>
                <?php echo $rs->title_name ?>
            </div>
            <hr style="border:<?php echo $rs->head_color ?> solid 1px; margin-top: 0px; margin-bottom: 0px;"/>

            <div class="list-group" style="height:250px; margin-bottom:0px; overflow:auto; border:#E0E0E0 solid 1px; background:#FFFFFF;">
                <table class="table table-striped">
                    <?php
                    $subhomepage = $sub_homepage->get_subhomepage($rs->id, $rs->limit);
                    $i = 0;
                    foreach ($subhomepage->result() as $sm):
                        $i++;
                        if ($i == 1) {
                            $img_new = '<img src="' . base_url() . 'images/icon_new.gif"/>';
                        } else {
                            $img_new = "";
                        }
                        if ($sm->final == 0) {
                            $linkMenu = site_url('homepage/viewupper/' . $this->takmoph_libraries->encode($sm->id) . '/' . $sm->id);
                            $count = '<span class="badge">' . $sub_homepage->CountHomePage($sm->id) . '</span>';
                        } else {
                            $linkMenu = site_url('homepage/view/' . $this->takmoph_libraries->encode($sm->id));
                            $count = "";
                        }
                        ?>
                        <tr>
                            <td>
                                <a href="<?php echo $linkMenu ?>"  style="text-decoration: none;border-radius:0px; border-left:none; border-right: none;">
                                    <?php if ($sm->final == 1) { ?>
                                        <font style="color:red; font-size: 12px;">
                                        <i class="fa fa-calendar"></i>
                                        <?php echo $model->thaidate($sm->create_date) ?>
                                        </font>
                                    <?php } else { ?>
                                        <img src="<?php echo base_url() ?>images/blue-folder-icon.png" style="width:24px;"/>
                                    <?php } ?>
                                    <?php echo $sm->title ?> <?php echo $img_new; ?>
                     
                                        <?php if ($sm->final == 0) { ?>
                                            <?php echo $count ?>    
                                        <?php } else { ?>
                                            <img src="<?php echo base_url() ?>images/document-icon.png" style="width:24px;"/>
                                        <?php } ?>
                              
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <?php if ($subhomepage->result()) { ?>
                <a href="<?php echo site_url('homepage/all/' . $this->takmoph_libraries->encode($rs->id)) ?>">
                    <button type="button" class="btn btn-xs pull-right hvr-curl-top-right" style="margin-top: 0px; background:none; color: #666666;">ทั้งหมด ...<i class="fa fa-angle-double-right"></i></button></a>
                    <?php } ?>

        </div>
    <?php endforeach; ?>
</div>

