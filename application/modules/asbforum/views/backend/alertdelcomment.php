<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = array(
    array("label" => 'จัดการ',"url" => 'asbforum/backend')
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

<table class="table">
    <thead>
        <tr>
            <th>คอมเม้นที่</th>
            <th>เจ้าของ</th>
            <th>ผู้แจ้งลบ</th>
            <th>วันที่แจ้งลบ</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($comment->result() as $rs): ?>
            <tr>
                <td><?php echo $rs->id ?></td>
                <td><?php echo $rs->alias ?></td>
                <td><?php echo $rs->aliassend ?></td>
                <td><?php echo $rs->datesend ?></td>
                <td><a href="<?php echo site_url('asbforum/backend/viewcomment/'.$rs->comment_id) ?>">เนื้อหา</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
