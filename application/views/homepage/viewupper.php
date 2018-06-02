<style type="text/css">
    #tb_subhome tbody tr{
        border-bottom: #999999 dashed 1px;
    }

    #tb_subhome tbody tr td a{
        text-decoration: none;
    }
</style>
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'homepage/all/' . $this->takmoph_libraries->encode($submenu->homepage_id), 'label' => $submenu->title_name),
        //array('url' => '', 'label' => 'menu2')
);

$active = $submenu->title;
//$list = "";
//echo $model->breadcrumb($list, $active);
//print_r($homepage);
//print_r($submenu);
?>

<?php echo $model->breadcrumb($list, $active); ?>

<h3 style="word-wrap: break-word;" id="head_submenu">
    <?php echo $submenu->title; ?>
</h3>
<hr id="hr"/>
<table class="table table-hover" id="tb_subhome">
    <thead>
        <tr style=" display: none;">
            <th style="display: none;">#</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($result->result() as $rs):
            $i++;
            ?>
            <tr>
                <td style="display: none;"><?php echo $i; ?></td>
                <td>
                    <a href="<?php echo site_url('homepage/view/' . $this->takmoph_libraries->encode($rs->id) . '/' . $submenu->id) ?>">
                        <font style=" color: #ff0000;"><i class="fa fa-calendar"></i> <?php echo $model->thaidate($rs->create_date) ?> </font>
                        <?php echo $rs->title; ?></a>
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