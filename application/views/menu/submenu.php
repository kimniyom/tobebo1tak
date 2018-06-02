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
?>
<?php echo $model->breadcrumb($list, $active); ?>

<div class="row" style=" margin: 0px; padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1" style=" padding-top: 20px;">
        <img src="<?= base_url() ?>icon_menu/<?php echo $masmenu->icon ?>" class="img-responsive"> 
    </div>
    <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11" style="padding-right: 0px;">
        <h3 style=" word-wrap: break-word;"><?php echo $head ?></h3>
    </div>
</div>

<hr id="hr"/>

<table class="table table-hover table-bordered table-responsive" id="tb_submenu">
    <thead style=" display: none;">
        <tr>
            <th style=" display: none;">#</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($submenu->result() as $sub):
            $i ++;
            /*
              if ($sub->link != '') {
             */
            $url = array('menu/views', $this->takmoph_libraries->encode($sub->sub_id), $sub->mas_id);
            $target = "";
            $typefile = "fa fa-file-zip-o";
            /*
              } else {

              $link = base_url() . "file_download/" . $sub->file;
              $target = "target='_blank'";
              $text = "Download";
              $file = substr($sub->file, -3);
              if ($file == "pdf") {
              $typefile = "fa fa-file-pdf-o";
              } else if ($file == "zip") {
              $typefile = "fa fa-file-zip-o";
              } else if ($file == "rar") {
              $typefile = "fa fa-file-zip-o";
              } else {
              $typefile = "fa fa-file-o";
              }
              /*
              }
             * 
             */
            ?>
            <tr>
                <td style=" display: none;"><?php echo $i; ?></td>
                <td>
                    <a href="<?php echo site_url($url) ?>" style=" text-decoration: none;"><i class="<?php echo $typefile ?> fa-2x text-warning"></i> 
                        <?= $sub->sub_name ?> <?php if ($sub->d_update) echo "(" . $model->thaidate($sub->d_update) . ")";
                    else echo ""; ?></a>
                </td>
            </tr>

<?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function () {
        $("#tb_submenu").dataTable();
    });
</script>

<script type="text/javascript">
    $("#document").ready(function () {
        $("#side-left").hide();
        $("#side-right").removeClass('col-xs-12 col-sm-12 col-md-9 col-lg-9 BR');
        $("#side-right").addClass('col-md-12 col-lg-12');
    });
</script>