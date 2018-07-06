<style type="text/css">
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
<?php if ($activity->num_rows() > 0) { ?>
    <div style="font-size:24px; font-weight: bold;">
        <i class="fa fa-trophy"></i> 10 ลำดับล่าสุด
    </div>
    <table class="table" id="b-activity">
        <tbody>
            <?php
            foreach ($activity->result() as $rs):
                $sql = "select * from tobe_activity_images where activity_id = '" . $rs->id . "' limit 1";
                $rimg = $this->db->query($sql)->row();
                $imgs = $rimg->images;
                if(!empty($imgs)){
                    $img = "upload_images/tobeactivity/thumb/".$imgs;
                } else {
                    $img = "assets/module/toberegis/images/Logo_TO_BE_NUMBER_ONE.png";
                }
                ?>
            <tr onclick="detailactivity('<?php echo $this->takmoph_libraries->url_encode($rs->id) ?>')">
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
    <div class="row" style=" clear: both;">
        <a href="<?php echo site_url('toberegis/tobeactivity/all') ?>" class=" pull-right" style=" margin-right: 20px;">
            <button type="button" class="btn btn-default btn-sm hvr-curl-top-right" style=" margin-right: 0px; background:none; color: #999999; border: none;">ดูทั้งหมด <i class="fa fa-arrow-circle-o-right"></i></button>
        </a>
    </div>
<?php } else { ?>
    <center>ไม่มีข้อมูล</center>
<?php } ?>
<script type="text/javascript">
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
    
    function detailactivity(eid){
        var url = "<?php echo site_url('toberegis/tobeactivity/view') ?>" + "/" + eid;
        window.location = url;
    }
</script>

