<style type="text/css">
    .box-all{
        height: 350px;
    }
    #tagdate{
        position: absolute;
        top:0px;
        left:0px;
        z-index: 10;
        padding: 5px;
        background: #FFFFFF;
        opacity: 0.7;
    }
    #box-location{
        position: absolute;
        bottom: 0px;
        left: 0px;
        font-size: 12px;
    }
</style>
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
/*
  $list = array(
  array('url' => '', 'label' => 'menu1'),
  array('url' => '', 'label' => 'menu2')
  );
 * 
 */

$active = $head;
$list = "";
echo $model->breadcrumb($list, $active);
?>

<hr id="hr"/>
<div class="row">
    <div class="col-sm-12 col-md-3 col-lg-3">
        <div style="padding:2px 5px; font-weight: bold; font-size:28px; color: #ff0000;"><i class="fa fa-newspaper-o"></i> ประเภทหน่วยงาน</div>
        <hr id="hr" style="border-color: #E13300;"/>
        <div class="list-group">

            <?php
            $typenews = $this->news->GettypeAll();
            foreach ($typenews->result() as $rs):
                if ($type_id == $rs->id) {
                    $icon = "<div style='background:#E13300; float: left; left:0px;top:0px;width:5px;height:100%; position: absolute;'></div>";
                } else {
                    $icon = "";
                }
                ?>
                <a href="<?php echo site_url('toberegis/tobenews/newsall/' . $this->takmoph_libraries->url_encode($rs->id)) ?>" class="list-group-item" style=" border-radius: 0px;"><?php echo $icon ?> <?php echo $rs->type ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-sm-12 col-md-9 col-lg-9">
        <div style="padding:2px 5px; font-weight: bold; font-size:28px; color: #ff0000;"><i class="fa fa-university"></i> <?php echo $head ?></div>
        <hr id="hr" style="border-color: #E13300;"/>
        <?php
        $i = 0;
        if ($new->num_rows() > 0) {
            foreach ($new->result() as $news): $i++;
                $images = $this->news->get_first_images_news($news->id);
                ?>

                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <a href="<?php echo site_url('toberegis/tobenews/view/' . $this->takmoph_libraries->url_encode($news->id) . '/' . $news->type) ?>" style=" text-decoration: none;">
                        <div class="container-card set-views-card" style=" height: 280px;">
                            <div id="div-bg-boxnew"></div>
                            <font style="font-size: 14px; color: #ff3300;" class="pull-left" id="tagdate"><?php echo $model->thaidate($news->date) ?></font>
                            <div class="img-wrapper">
                                <?php if (!empty($images)) { ?>
                                    <img src="<?php echo base_url() ?>upload_images/news/thumb/<?php echo $images; ?>" class="img-responsive" style="height:200px;"/>
                                <?php } else { ?>
                                    <center>
                                        <img src="<?php echo base_url() ?>images/News-Mic-iPhone-icon.jpg" class="img-responsive"/>
                                    </center>
                                <?php } ?>
                            </div>
                            <p class="details" style=" color: #996600; padding: 5px; text-align: left;">
                                <?php echo $news->title ?>
                            </p>
                            <div id="box-location">
                                <i class="fa fa-user"></i> <?php echo $news->name . ' ' . $news->lname ?>
                                <em><?php echo $this->tobeuser->getlocation($news->user_id, $news->type) ?></em>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php } else { ?>
            <center>ไม่มีข้อมูล</center>          
        <?php } ?>
    </div>

</div>
<div style="text-align:center;">
    <?php echo $s_pagination ?>
</div>

<script type="text/javascript">
    $("#document").ready(function () {
        $("#side-left").hide();
        $("#side-right").removeClass('col-xs-12 col-sm-12 col-md-9 col-lg-9 BR');
        $("#side-right").addClass('col-md-12 col-lg-12');
    });
</script>
