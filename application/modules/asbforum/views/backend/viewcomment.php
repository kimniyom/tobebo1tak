<script type="text/javascript">
    $(document).ready(function () {
        var widthimgs = $(".viewcommentt").width();
        var imgs = $(".viewcomment img").width();
        if (imgs >= widthimgs) {
            $(".viewcomment img").addClass("img-responsive");
            $(".viewcomment img").css({"width": "auto", "height": "auto"});
        }
    });
</script>
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = array(
    array("label" => "คอมเม้นแจ้งลบ", "url" => "asbforum/backend/alertdelcomment")
);
$active = $head;
?>

<?php echo $model->breadcrumb_backend($list, $active); ?>
<h3 id="head_submenu">
    <i class="fa fa-file-text-o fa-2x text-warning"></i>
    คอมเม้นเลขที่ <?php echo $head; ?>
</h3>

<hr id="hr"/>
<button type="button" class="btn btn-danger" onclick="Deletepost('<?php echo $comment->id ?>')"><i class="fa fa-trash-o"></i> ยืนยันการลบ</button>
<button type="button" class="btn btn-primary" onclick="Cancelpost('<?php echo $comment->id ?>')"><i class="fa fa-remove"></i> ยกเลิกการแจ้งลบกระทู้</button>
<br/><br/>

<div class="viewcomment">
    <?php echo $comment->comment ?>
</div>

<script type="text/javascript">
    function Deletepost(postID) {
        var r = confirm("Are you sure...");
        var url = "<?php echo site_url('asbforum/backend/deletepost') ?>";
        var data = {post_id: postID};
        if (r == true) {
            $.post(url, data, function (datas) {
                var urldir = "<?php echo site_url('asbforum/backend/alertdelpost') ?>";
                window.location = urldir;
            });
        }
    }

    function Cancelpost(postID) {
        var r = confirm("Are you sure...");
        var url = "<?php echo site_url('asbforum/backend/cancelpost') ?>";
        var data = {post_id: postID};
        if (r == true) {
            $.post(url, data, function (datas) {
                var urldir = "<?php echo site_url('asbforum/backend/alertdelpost') ?>";
                window.location = urldir;
            });
        }
    }
</script>
