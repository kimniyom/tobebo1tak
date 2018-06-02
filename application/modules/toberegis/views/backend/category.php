<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
if ($catID != "") {
    $navi = array('url' => 'asbforum/backend/category', 'label' => 'หมวด');
} else {
    $navi = null;
}
$list = array(
    array('url' => 'asbforum/backend', 'label' => 'จัดการเว็บบอร์ด'),
    $navi
);
$active = $head;
?>

<?php echo $model->breadcrumb_backend($list, $active); ?>
        <h3 id="head_submenu">
            <i class="fa fa-file-text-o fa-2x text-warning"></i>
            <?php
            echo $head;
            ?>
        </h3>

<hr id="hr"/>


<a href="<?php echo site_url('asbforum/backend/createcategory/' . $catID) ?>">
    <button type="button" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> เพิ่มหมวด</button></a>
<table class="table table-striped table-bordered" style=" background: #FFF;">
    <thead>
        <tr>
            <th style="text-align: center;">#</th>
            <th>หมวด</th>
            <th>รายละเอียด</th>
            <th>Avtive</th>
            <th>Sublevel</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($category->result() as $rs) {
            $i++;
            ?>
            <tr>
                <td style="text-align: center;"><?php echo $i ?></td>
                <td>
                    <?php if ($rs->level == 1) { ?>
                        <a href="<?php echo site_url('asbforum/backend/category/' . $rs->id) ?>"><?php echo $rs->title ?></a>
                    <?php } else { ?>
                        <?php echo $rs->title ?>
                    <?php } ?>
                </td>
                <td><?php echo $rs->detail ?></td>
                <td><?php echo $rs->active ?></td>
                <td><?php echo $rs->level ?></td>
                <td style=" text-align: center;">
                    <a href="<?php echo site_url('asbforum/backend/updatecategory/' . $rs->id) ?>"><i class="fa fa-pencil"></i></a>
                    <a href="javascript:deletecategory('<?php echo $rs->id ?>')"><i class="fa fa-trash-o"/></i></a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
    function deletecategory(id) {
        var url = "<?php echo site_url('asbforum/backend/deletecategory') ?>";
        var data = {id: id};
        var r = confirm("Are you sure ..?");
        if (r == true) {
            $.post(url, data, function (datas) {
                window.location.reload();
            });
        }
    }
</script>

