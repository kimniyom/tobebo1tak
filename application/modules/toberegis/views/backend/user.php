<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = array(
    array('url' => 'asbforum/backend', 'label' => 'จัดการเว็บบอร์ด')
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

<table class="table" id="user-forum">
    <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>Alias</th>
            <th>ConfirmEmail</th>
            <th>RegisterDate</th>
            <th>Block</th>
        </tr>
    </thead>  
    <tbody>
        <?php $i=0;foreach($user->result() as $rs): $i++;?>
        <tr>
            <td><?php echo $i ?></td>
            <td>
                <a href="<?php echo site_url('asbforum/backend/userview/'.$rs->id)?>">
                <?php echo $rs->username ?></a>
            </td>
            <td><?php echo $rs->alias ?></td>
            <td><?php echo $rs->active ?></td>
            <td><?php echo $rs->register_date ?></td>
            <td><?php echo $rs->block ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>  
</table>

<script>
    $(document).ready(function(){
        $("#user-forum").dataTable();
    });
</script>