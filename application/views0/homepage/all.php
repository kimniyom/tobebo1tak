<style type="text/css">
    #link-homepage{
        text-decoration: none;
    }
</style>
<?php
$this->load->library('takmoph_libraries');
$this->load->model('sub_homepage_model');
$model = new takmoph_libraries();
$ModelSubhomepage = new sub_homepage_model();
/*
  $list = array(
  array('url' => 'backend/homepage', 'label' => 'ตัวอย่าง'),
  //array('url' => '', 'label' => 'menu2')
  );
 *
 */
$active = $head;
$list = "";
//echo $model->breadcrumb($list, $active);
?>

<?php echo $model->breadcrumb($list, $active); ?>


        <h3 style=" word-wrap: break-word;" id="head_submenu">
            <?php echo $homepage->title_name; ?>
        </h3>

<hr id="hr"/>

<table class="table table-striped" id="tb_subhome">
    <thead>
        <tr style=" display: none;">
            <th style="display: none;">#</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($result->result() as $rs):
            $i++;
            if ($rs->final == 0) {
                $icons = "fa fa-folder";
                $linkMenu = site_url('homepage/viewupper/' . $this->takmoph_libraries->encode($rs->id) . '/' . $rs->id);
                $btn = "btn-info";
                $fontcolor = "#58ACFA";
                $date = "";
                $Count = ' <span class="badge">' . $ModelSubhomepage->CountHomePage($rs->id) . '</span>';
            } else {
                $icons = "fa fa-calendar";
                $linkMenu = site_url('homepage/view/' . $this->takmoph_libraries->encode($rs->id));
                $btn = "btn-success";
                $fontcolor = "red";
                $date = $model->thaidate($rs->create_date);
                $Count = "";
            }
            ?>
            <tr>
                <td style="display: none;"><?php echo $i; ?></td>
                <td>
                    <font style="color: <?php echo $fontcolor ?>;"><i class="<?php echo $icons ?>"></i> <?php echo $date ?> </font>
                    <a href="<?php echo $linkMenu ?>" id="link-homepage"><?php echo $rs->title; ?><?php echo $Count ?></a>
                </td>
                <td style=" width: 10%; text-align: center;">

                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function () {
        $("#tb_subhome").DataTable();
    });
</script>

<script type="text/javascript">
    $("#document").ready(function () {
        $("#side-left").hide();
        $("#side-right").removeClass('col-xs-12 col-sm-12 col-md-9 col-lg-9 BR');
        $("#side-right").addClass('col-md-12 col-lg-12');
    });
</script>