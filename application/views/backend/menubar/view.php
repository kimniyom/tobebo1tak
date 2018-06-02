<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = array(
    array('url' => 'backend/menubar', 'label' => 'MenuBar'),
        //array('url' => '', 'label' => 'menu2')
);

$active = $head;
//$list = "";
echo $model->breadcrumb_backend($list, $active);
?>
<h3><i class="fa fa-magic"></i> <?php echo $head ?></h3>
<hr/>
<?php if($page->type != '2'){ ?>
<a href="<?php echo site_url('backend/menubar/update/' . $page->id) ?>">
    <button type="button" class="btn btn-default"><i class="fa fa-pencil text-warning"></i></button></a>
<?php } ?>
<button type="button" class="btn btn-default"
        onclick="delete_page('<?php echo $page->id ?>')"><i class="fa fa-trash text-danger"></i></button>
<h4><?php echo $page->title ?></h4>
<div class="detail_news">
    <?php if($page->type == '2'){ ?>
        Url => <?php echo $page->link ?>
    <?php } else { ?>
    <?php echo $page->page ?>
    <?php } ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".detail_news img").addClass("img-responsive");
        $(".detail_news img").css({"width": "auto", "height": "auto"});
    });

    function delete_page(id) {
        var r = confirm("คุณแน่ใจหรือไม่ที่จะลบ ...");
        if (r == true) {
            var url = "<?php echo site_url('backend/menubar/delete') ?>";
            var data = {id: id};
            $.post(url, data, function (success) {
                window.location = "<?php echo site_url('backend/menubar') ?>";
            });
        }
    }
</script>
