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

<div class="row">
    <div class="col-md-2 col-lg-2">
        ข้อตกลง
    </div>
    <div class="col-md-10 col-lg-10">
        <input type="hidden" id="id"/>
        <textarea class="form-control" id="agreement" rows="5"></textarea>
    </div>
</div>

<div class="row" style=" margin-top: 10px;">
    <div class="col-md-2 col-lg-2"></div>
    <div class="col-md-10 col-lg-10">
        <button type="button" class="btn btn-success btn-sm" onclick="Save()">บันทึกข้อมูล</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="window.location.reload()"><i class="fa fa-refresh"></i> Refresh</button>
    </div>
</div>

<hr/>
<ul>
    <?php foreach ($agreement->result() as $rs): ?>
        <li>
            <?php echo $rs->agreement ?> 
             <span >
                <a href="javascript:Edit('<?php echo $rs->id ?>','<?php echo $rs->agreement ?>')"><i class="fa fa-pencil-square-o"></i></a>
            </span>
            <span>
                <a href="javascript:Delete('<?php echo $rs->id ?>')"><i class="fa fa-trash-o"></i></a>
            </span>
        </li>
    <?php endforeach; ?>
</ul>

<script type="text/javascript">
    function Save() {
        var id = $("#id").val();
        var url = "";
        if (id == "") {
            url = "<?php echo site_url('asbforum/backend/saveagreement') ?>";
        } else {
            url = "<?php echo site_url('asbforum/backend/saveupdateagreement') ?>";
        }
        var agreement = $("#agreement").val();
        var data = {id: id,agreement: agreement};
        if (agreement == "") {
            $("#agreement").focus();
            return false;
        }
        $.post(url, data, function (datas) {
            window.location.reload();
        });
    }

    function Edit(id, agreement) {
        $("#id").val(id);
        $("#agreement").val(agreement);
    }
    
    function Delete(id){
         var url = "<?php echo site_url('asbforum/backend/deleteagreement') ?>";
        var data = {id: id};
        var r = confirm("Are you sure ..?");
        if (r == true) {
            $.post(url, data, function (datas) {
                window.location.reload();
            });
        }
    }
</script>