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
        ประเภท
    </div>
    <div class="col-md-10 col-lg-10">
        <input type="hidden" id="id"/>
        <textarea class="form-control" id="typealert" rows="5"></textarea>
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
<table class="table table-bordered">
    <?php foreach ($typealert->result() as $rs): ?>
        <tr>
            <td><?php echo $rs->typealert ?></td>
            <td style="text-align: right; width: 15%;">
                <a href="javascript:Edit('<?php echo $rs->id ?>','<?php echo $rs->typealert ?>')"><i class="fa fa-pencil-square-o"></i></a>
                <a href="javascript:Delete('<?php echo $rs->id ?>')"><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<script type="text/javascript">
    function Save() {
        var id = $("#id").val();
        var url = "";
        if (id == "") {
            url = "<?php echo site_url('asbforum/backend/savetypealert') ?>";
        } else {
            url = "<?php echo site_url('asbforum/backend/saveupdatetypealert') ?>";
        }
        var typealert = $("#typealert").val();
        var data = {id: id, typealert: typealert};
        if (typealert == "") {
            $("#typealert").focus();
            return false;
        }
        $.post(url, data, function (datas) {
            window.location.reload();
        });
    }

    function Edit(id, typealert) {
        $("#id").val(id);
        $("#typealert").val(typealert);
    }

    function Delete(id) {
        var url = "<?php echo site_url('asbforum/backend/deletetypealert') ?>";
        var data = {id: id};
        var r = confirm("Are you sure ..?");
        if (r == true) {
            $.post(url, data, function (datas) {
                window.location.reload();
            });
        }
    }
</script>