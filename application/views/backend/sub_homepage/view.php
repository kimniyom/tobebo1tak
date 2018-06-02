<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
if (!empty($subhomepage_id)) {
    $link = 'backend/sub_homepage/viewpper/' . $subhomepage_id . '/' . $homepage_id;
    $label = $subhomepage->title;
} else {
    $link = "";
    $label = "";
}
$list = array(
    array('url' => 'backend/homepage', 'label' => 'ตัวอย่าง'),
    array('url' => 'backend/sub_homepage/all/' . $result->homepage_id, 'label' => $result->title_name),
    array('url' => $link, 'label' => $label)
);



$active = $head;
//$list = "";
echo $model->breadcrumb_backend($list, $active);
$users = $this->user->view($result->owner);
?>
<h3>
    <i class="fa fa-newspaper-o"></i>
    <?php
    $text = strlen($result->title);
    if ($text > 250) {
        //echo iconv_substr($news->titel,'0','100')."...";
        print mb_substr($result->title, 0, 50, 'UTF-8') . "...";
    } else {
        echo $result->title;
    }
    ?>

</h3>
<hr/>
<?php if ($result->owner == $this->session->userdata('user_id') || $this->session->userdata('status') == 'S') { ?>
    <!--
      <a href="<?//php echo site_url('backend/sub_homepage/update/' . $result->id) ?>">
        <button type="button" class="btn btn-default"><i class="fa fa-pencil text-success"></i> แก้ไข</button></a>
        <button type="button" class="btn btn-default" onclick="delete_subhomepage('<?//php echo $result->id ?>')"><i class="fa fa-trash-o text-danger"></i> ลบ</button>
    -->
<?php } ?>
<h4>
    เรื่อง :: <?php echo $result->title ?>
</h4>
<br/>

<?php echo $result->detail ?>
<br/>

<hr/>
<div class="pull-right">
    <?php echo $model->thaidate($result->create_date) ?> <em style=" color: #999999;">(โดย : <?php echo $users->name . ' ' . $users->lname ?>)</em>
</div>

<script type="text/javascript">
    function delete_subhomepage(Id) {
        var r = confirm("คุณต้องการลบข้อมูลใช่ หรือ ไม่ ...?");
        if (r == true) {
            var url = "<?php echo site_url('backend/sub_homepage/delete') ?>";
            var home_id = "<?php echo $result->homepage_id ?>";
            var data = {id: Id};

            $.post(url, data, function (success) {
                window.location = "<?php echo site_url('backend/sub_homepage/all/') ?>" + "/" + home_id;
            });
        }
    }
</script>
