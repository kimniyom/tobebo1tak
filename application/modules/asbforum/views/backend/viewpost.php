<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = array(
    array("label" => "กระทู้แจ้งลบ", "url" => "asbforum/backend/alertdelpost")
);
$active = $head;
?>

<?php echo $model->breadcrumb_backend($list, $active); ?>
<h3 id="head_submenu">
    <i class="fa fa-file-text-o fa-2x text-warning"></i>
    กระทู้เลขที่ <?php echo $head; ?>
</h3>

<hr id="hr"/>
<button type="button" class="btn btn-danger" onclick="Deletepost('<?php echo $post->id ?>')"><i class="fa fa-trash-o"></i> ยืนยันการลบ</button>
<button type="button" class="btn btn-primary" onclick="Cancelpost('<?php echo $post->id ?>')"><i class="fa fa-remove"></i> ยกเลิกการแจ้งลบกระทู้</button>
<br/><br/>
<table class="table table-bordered">
    <tr>
        <td>กระทู้</td>
        <td><?php echo $post->title ?></td>
    </tr>
    <tr>
        <td>รายละเอียด</td>
        <td><?php echo $post->detail ?></td>
    </tr>
    <tr>
        <td>เจ้าของโพสต์</td>
        <td><?php echo $post->alias ?></td>
    </tr>
    <tr>
        <td>หมวด</td>
        <td><?php echo $post->categorytitle ?></td>
    </tr>
    <tr>
        <td>วันที่</td>
        <td><?php echo $post->create_date ?></td>
    </tr>
</table>

<script type="text/javascript">
    function Deletepost(postID){
        var r = confirm("Are you sure...");
        var url = "<?php echo site_url('asbforum/backend/deletepost') ?>";
        var data = {post_id: postID};
        if(r == true){
            $.post(url,data,function(datas){
                var urldir = "<?php echo site_url('asbforum/backend/alertdelpost') ?>";
                window.location=urldir;
            });
        }
    }
    
    function Cancelpost(postID){
        var r = confirm("Are you sure...");
        var url = "<?php echo site_url('asbforum/backend/cancelpost') ?>";
        var data = {post_id: postID};
        if(r == true){
            $.post(url,data,function(datas){
                var urldir = "<?php echo site_url('asbforum/backend/alertdelpost') ?>";
                window.location=urldir;
            });
        }
    }
</script>
