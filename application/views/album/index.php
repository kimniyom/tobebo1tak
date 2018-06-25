<?php
$this->load->model('photo_model', 'photo');
?>
<!--main-->
<div class="container" id="album-views">
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
    //echo $model->breadcrumb($list, $active);
    ?>
<?php echo $model->breadcrumb($list, $active); ?>
    
            <h3 id="head_submenu"><img src="<?php echo base_url() ?>images/Album-icon.png" style="width:48px;"/> <?php echo $head ?></h3>
        
    <hr id="hr"/>
    <div class="row">
        <?php
        $i = 0;
        foreach ($album->result() as $albums): $i++;
            $images = $this->photo->get_first_album($albums->id);
            ?>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="container-card album-all" style="height:350px;">
                    <div id="div-bg-boxnew"></div>
                    <div class="img-wrapper">
                        <?php if (!empty($images)) { ?>
                            <img src="<?php echo base_url() ?>upload_images/photo/thumb/<?php echo $images; ?>" class="img-responsive img-polaroid" style="height:200px;"/>
                        <?php } else { ?>
                            <center>
                                <img src="<?php echo base_url() ?>upload_images/photo/<?php echo $images; ?>" class="img-responsive img-polaroid" style="height:200px;"/>
                            </center>
                        <?php } ?>
                    </div>
                    <p class="detail">
                        <?php
                        $text = strlen($albums->title);
                        if ($text > 160) {
                            //echo iconv_substr($news->titel,'0','100')."...";
                            if ($this->session->userdata('width') > 1000 || $this->session->userdata('width') <= 768) {
                                print mb_substr($albums->title, 0, 40, 'UTF-8') . "...";
                            } else {
                                echo $albums->title;
                            }
                        } else {
                            echo $albums->title;
                        }
                        ?>
                        <br/>
                        <font style=" font-size: 12px;" class="pull-right">
                        <?php echo $model->thaidate($albums->create_date) ?>
                        </font>
                    </p>

                    <div id="btn-card">
                        <a href="<?php echo site_url('photo/gallery/' . $albums->id) ?>">
                            <button type="button" class="btn btn-primary btn-xs">
                                <i class="fa fa-eye text-warning"></i> จำนวนรูปภาพ
                                <span class="badge"><?php echo $this->photo->count_gallery($albums->id); ?></button></span></a>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    </div>
    <div style="text-align:center;">
        <?php echo $s_pagination ?>
    </div>
</div>

<script type="text/javascript">
    $("#document").ready(function(){
       $("#side-left").hide();
       $("#side-right").removeClass('col-xs-12 col-sm-12 col-md-9 col-lg-9 BR');
       $("#side-right").addClass('col-md-12 col-lg-12');
    });
</script>
