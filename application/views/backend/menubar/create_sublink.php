
<script type="text/javascript">
    
    function Save_subpage() {
        var url = "<?php echo site_url('backend/menubar/save_sublink') ?>";
        var title = $("#title").val();
        var upper = "<?php echo $upper ?>";
        var link = $("#link").val();
        if (title == '' || link == '') {
            alert("กรอกข้อมูลไม่ครบ ...");
            return false;
        }
        var data = {
            title: title,
            link: link,
            upper: upper
        };
        $.post(url, data, function (success) {
            window.location = "<?php echo site_url('backend/menubar') ?>";
        });
    }
</script>

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
<h3><i class="fa fa-newspaper-o"></i> <?php echo $head ?></h3>
<hr/>
<div class="form-group">
    <label>เรื่อง</label>
    <input type="text" class="form-control" id="title"/>
    <label>Url</label>
    <input type="text" class="form-control" id="link" placeholder="Ex.http://www.google.com"/>
    <hr/>
    <button type="button" class="btn btn-primary" onclick="Save_subpage()">บันทึกข้อมูล</button>
</div>
