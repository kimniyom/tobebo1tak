<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$groupnewsModel = new groupnews_model();
if ($upper != 0) {
    $row = $this->db->get_where("forum_category", array("id" => $upper))->row();
    $list = array(
        array('url' => 'asbforum/post/category/' . $upper, 'label' => $row->title)
            //array('url' => '', 'label' => 'menu2')
    );
} else {
    $list = "";
}
/*

 * 
 */
$active = $head;
?>
<?php echo $model->breadcrumb_backend($list, $active, "asbforum"); ?>

<h3 id="head_submenu"><i class="fa fa-commenting-o"></i> <?php echo $head ?></h3>
<?php
if ($subcategory) {
    echo "<div class='row'><div class='col-md-2 col-lg-2' style='text-align:center;padding-top:15px;'><b>หมวดย่อย</b></div><div class='col-md-10 col-lg-10'><div class='row'>";
    foreach ($subcategory->result() as $cat) {
        ?>
        <div class="col-md-3 col-lg-3" style=" margin-top: 10px;">
            <a href="<?php echo site_url('asbforum/post/category/' . $cat->id) ?>" style=" text-decoration: none;">
                <div class="btn btn-default btn-block"><?php echo $cat->title ?></div></a>
        </div>
        <?php
    }
    echo "</div></div></div>";
}
?>
<hr/>
<?php if (!empty($category->detail)) { ?>
    เกี่ยวกับหมวด : <?php echo $category->detail ?>
    <hr/>
<?php } ?>
<table class="table" id="category">
    <thead>
        <tr>
            <th style=" display: none;"></th>
            <th style=" width: 20%;"></th>
            <th>กระทู้</th>
            <th style=" width: 10%; text-align: center;">อ่าน</th>
            <th style=" width: 10%; text-align: center;">ตอบ</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($post->result() as $rs): $i++
            ?>
            <tr>
                <td style=" display: none;"><?php echo $i ?></td>
                <td>
                    <div class="alert alert-success" style=" padding: 2px; margin: 0px; text-align:  center;"><?php echo $this->takmoph_libraries->thaidate($rs->create_date) ?></div>
                </td>
                <td><a href="<?php echo site_url('asbforum/post/view/' . $rs->id) ?>"><?php echo $rs->title ?></a></td>
                <td style="text-align: center;"><span class="badge"><?php echo number_format($rs->readpost) ?></span></td>
                <td style="text-align: center;"><span class="badge"><?php echo number_format($this->forum->CountComment($rs->id)) ?></span></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function () {
        $("#category").dataTable({
            "pageLength": 50,
            "bLengthChange": false
        });
    });
</script>
