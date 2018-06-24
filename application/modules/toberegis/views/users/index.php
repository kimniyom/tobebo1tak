<style type="text/css">
    .row{
        margin-bottom: 10px;
    }
</style>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = array(
        //array("label" => 'Dashboard',"url" => 'toberegis')
);
$active = $head;
?>
<?php echo $model->breadcrumb_backend($list, $active); ?>
<div style=" clear: both;">
    <h3><i class="fa fa-user"></i> ผู้ใช้งาน</h3>
    <hr/>
</div>
<a href="<?php echo site_url('toberegis/users/createuser') ?>">
    <button type="button" class="btn btn-default"><i class="fa fa-plus"></i> เพิ่มผู้ใช้งาน</button></a>
<table class="table">
    <thead>
        <tr>
            <th>Username</th>
            <th>ชื่อ - สกุล</th>
            <th>สถานนะสิทธิ์</th>
            <th>สิทธิ์</th>
            <th style=" text-align: center;">Block</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($user->result() as $rs): ?>
            <tr>
                <td><?php echo $rs->username ?></td>
                <td><?php echo $rs->name . ' ' . $rs->lname ?></td>
                <td><?php echo $rs->typename ?></td>
                <td>
                    <?php
                     $userprivilege = $this->usermodel->Checkprivilege($rs->id);
                    if ($userprivilege == "0") {
                    ?>
                    <a href="<?php echo site_url('toberegis/users/privilege/' . $this->takmoph_libraries->url_encode($rs->id)) ?>" class='text-success'><i class='fa fa-plus'></i> กำหนดสิทธิ์</a>
                    <?php } else { ?>
                        <a href="<?php echo site_url('toberegis/users/privilegeupdate/' . $this->takmoph_libraries->url_encode($rs->id)) ?>" class='text-danger'><i class='fa fa-cog'></i> จัดการสิทธิ์</a>
                    <?php } ?>
                </td>
                <td style=" text-align: center;">
                    <?php if ($rs->block == "N") { ?>
                        <button type="button" class="btn btn-danger btn-sm btn-block">Block User</button>
                    <?php } else { ?>
                        <button type="button" class="btn btn-success btn-sm btn-block">UnBlock</button>
                    <?php } ?>
                </td>
                <td style=" text-align: center;">
                    <i class="fa fa-trash-o text-danger"></i>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>