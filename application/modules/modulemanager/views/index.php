<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
        //array('url' => 'backend/form_download/get_mas_from', 'label' => 'แบบฟอร์ม'),
);

$active = $head;
echo $model->breadcrumb_backend($list, $active);
?>
<h3><i class="fa fa-cogs"></i> <?= $head ?></h3>

<div class="panel panel-danger">
    <div class="panel-heading">
        <button type="button" class="btn btn-default"><i class="fa fa-plus-circle"></i> Upload Module</button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Module</th>
                <th>Path</th>
                <th>Thainame</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($module->result() as $rs): $i++;
                ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $rs->module ?></td>
                    <td><?php echo $rs->path ?></td>
                    <td><?php echo $rs->thainame ?></td>
                    <td><?php echo $rs->active ?></td>
                    <td><?php echo $i ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>