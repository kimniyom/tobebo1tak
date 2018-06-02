<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'backend/homepage', 'label' => 'ตัวอย่าง'),
    array('url' => 'backend/sub_homepage/all/'.$menu->id, 'label' => $menu->title_name),
);

$active = $head;
//$list = "";
echo $model->breadcrumb_backend($list, $active);
?>
<h3><i class="fa fa-newspaper-o"></i> <?php echo $head ?></h3>
<hr/>
<a href="<?php echo site_url('backend/sub_homepage/create_upper/' . $result->id. '/' . $menu->id) ?>">
    <button type="button" class="btn btn-default"><i class="fa fa-plus-circle"></i> เพิ่มเนื้อหา</button></a>
    <hr/>
<table class="table table-striped" id="tb_subhome">
    <thead>
        <tr>
            <th style=" width: 2%;">#</th>
            <th>หัวข้อ</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($upper->result() as $rs):
            $users = $this->user->view($rs->owner);
            $i++;
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td>
                    <?php echo $model->thaidate($rs->create_date) ?> <?php echo $rs->title; ?>
                    <em style=" color: #999999;">(โดย : <?php echo $users->name . ' ' . $users->lname ?>)</em>
                </td>
                <td style=" text-align: right; width: 15%;">
                    <a href="<?php echo site_url('backend/sub_homepage/view/' . $rs->id.'/'.$result->id. '/' . $menu->id) ?>">
                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-eye text-info"></i></button></a>
                    <?php if ($rs->owner == $this->session->userdata('user_id') || $this->session->userdata('status') == 'S') { ?>
                        <a href="<?php echo site_url('backend/sub_homepage/update/' . $rs->id) ?>">
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-pencil text-warning"></i></button></a>
                        <button type="button" class="btn btn-default btn-sm" onclick="delete_subhomepage('<?php echo $rs->id ?>')"><i class="fa fa-trash text-danger"></i></button>
                        <?php } ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function(){
       $("#tb_subhome").dataTable(); 
    });
    function delete_subhomepage(Id) {
        var r = confirm("คุณต้องการลบข้อมูลใช่ หรือ ไม่ ...?");
        if (r == true) {
            var url = "<?php echo site_url('backend/sub_homepage/delete') ?>";
            var data = {id: Id};

            $.post(url, data, function (success) {
                window.location.reload();
            });
        }
    }
</script>
