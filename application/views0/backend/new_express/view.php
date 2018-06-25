<?php
$this->load->library('takmoph_libraries');
$lib = new takmoph_libraries();

$list = array(
    array('url' => 'backend/newexpress', 'label' => 'ประกาศ'),
        //array('url' => '', 'label' => 'menu2')
);

$text = strlen($model->title);
if ($text > 50) {
    $h = mb_substr($model->title, 0, 40, 'UTF-8') . "...";
} else {
    $h = $model->title;
}

$active = $h;
//$list = "";
echo $lib->breadcrumb_backend($list, $active);
?>
<h3><i class="fa fa-newspaper-o"></i> ประกาศด่วน</h3>
<hr/>
<div class="container">
    <a href="<?php echo site_url('backend/newexpress/update/' . $model->id) ?>">
        <button type="button" class="btn btn-primary">แก้ไข</button></a>
    <button type="button" class="btn btn-danger" onclick="delete_express('<?php echo $model->id ?>')">ลบ</button>
    <br/>
    <h4>เรื่อง :: <?php echo $model->title; ?></h4><br/>
    <?php echo $model->detail ?>
    <hr/>
    <div class="pull-right" style=" margin-right: 15px;"><?php echo $model->create_date; ?></div>
</div>

<script type="text/javascript">
    function delete_express(id) {
        var r = confirm("คุณต้องการลบ ใช่ หรือ ไม่ ...");
        if (r == true) {
            var url = "<?php echo site_url('backend/newexpress/delete') ?>";
            var data = {id: id};

            $.post(url, data, function (success) {
                window.location = "<?php echo site_url() ?>backend/newexpress";
            });
        }
    }
</script>
