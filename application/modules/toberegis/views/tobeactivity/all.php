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
    #b-activity tbody tr{
        border-bottom: #dfdfdf solid 1px;
    }
    #b-activity tbody tr td{
        padding: 5px;
    }
    #b-activity tbody tr{
        cursor: pointer;
        color: #666666;
    }
    #b-activity tbody tr:hover{
        cursor: pointer;
        color: #ff6633;
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
            $typeactivity = $this->activity->GettypeAll();
            foreach ($typeactivity->result() as $rs):
                if ($type_id == $rs->id) {
                    $icon = "<div style='background:#E13300; float: left; left:0px;top:0px;width:5px;height:100%; position: absolute;'></div>";
                } else {
                    $icon = "";
                }
                ?>
                <a href="<?php echo site_url('toberegis/tobeactivity/all/' . $this->takmoph_libraries->url_encode($rs->id)) ?>" class="list-group-item" style=" border-radius: 0px;"><?php echo $icon ?> <?php echo $rs->type ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-sm-12 col-md-9 col-lg-9">
        <div style="padding:2px 5px; font-weight: bold; font-size:28px; color: #ff0000;"><i class="fa fa-university"></i> <?php echo $head ?></div>
        <hr id="hr" style="border-color: #E13300;"/>
        <?php if ($activity->num_rows() > 0) { ?>
            <table class="table" id="b-activity">
                <tbody>
                    <?php
                    foreach ($activity->result() as $rs):
                        $sql = "select * from tobe_activity_images where activity_id = '" . $rs->id . "' limit 1";
                        $rimg = $this->db->query($sql)->row();
                        $imgs = $rimg->images;
                        if (!empty($imgs)) {
                            $img = "upload_images/tobeactivity/thumb/" . $imgs;
                        } else {
                            $img = "assets/module/toberegis/images/Logo_TO_BE_NUMBER_ONE.png";
                        }
                        
                        ?>
                        <tr>
                            <td class="img-activity" style=" padding: 0px;">
                                <div class="img-wrapper">
                                    <img src="<?php echo base_url() ?><?php echo $img ?>" class="img-polaroid img-news-all" style="height:100px;"/>
                                </div>
                            </td>
                            <td>
                                <span class="text-activity" style=" color: #000000;"><?php echo $rs->title ?></span><br/>
                                <i class="fa fa-user"></i> 
                                <?php echo $rs->name . ' ' . $rs->lname ?>
                                <?php echo $this->tobeuser->getlocation($rs->user_id, $rs->type) ?>
                                <br/>
                                <i class="fa fa-calendar"></i> <?php echo $rs->date ?><br/>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php } else { ?>
            <center>ไม่มีข้อมูล</center>
        <?php } ?>
        <div style="text-align:center;">
            <?php echo $s_pagination ?>
        </div>
    </div>

</div>

<script type="text/javascript">
    $("#document").ready(function () {
        $("#side-left").hide();
        $("#side-right").removeClass('col-xs-12 col-sm-12 col-md-9 col-lg-9 BR');
        $("#side-right").addClass('col-md-12 col-lg-12');
    });
    setboxactivity();
    function setboxactivity() {
        var w = window.innerWidth;
        if (w > 768) {
            $(".img-activity").css({'width': '20%'});
            $(".text-activity").css({'font-size': '24px'});
        } else {
            $(".img-activity").css({'width': '30%'});
        }
    }
</script>



