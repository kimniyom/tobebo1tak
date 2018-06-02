<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = "";
$active = $head;

$yearNow = date("Y");
$datamonths = $this->tak->GetMonth();

if ($year == "") {
    $years = "";
} else {
    $years = $year;
}

if ($month == "") {
    $months = "";
} else {
    $months = $month;
}
?>

<?php echo $model->breadcrumb_backend($list, $active); ?>

<h3 id="head_submenu">
    <i class="fa fa-file-text-o fa-2x text-warning"></i>
    <?php echo $head; ?>
</h3>
<hr/>
<div class="row">
    <div class="col-md-3 col-lg-3">
        <label>ปี</label>
        <select id="year" class="form-control">
            <option value="">ทั้งหมด</option>
            <?php for ($i = $yearNow; $i >= ($yearNow - 2); $i--): ?>
                <option value="<?php echo $i ?>" <?php if ($i == $years) echo "selected"; ?>><?php echo ($i + 543) ?></option>
            <?php endfor; ?>
        </select>
    </div>
    <div class="col-md-3 col-lg-3">
        <label>เดือน</label>
        <select id="month" class="form-control">
            <option value="">ทั้งหมด</option>
            <?php foreach ($datamonths->result() as $m): ?>
                <option value="<?php echo $m->month_val ?>" <?php if ($m->month_val == $months) echo "selected"; ?>><?php echo $m->month_th ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2 col-lg-2">
        <button type="button" class="btn btn-default" style=" margin-top: 25px;" onclick="getdata()"><i class="fa fa-search"></i></button>
    </div>
</div>
<hr/>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>เรื่อง</th>
            <th>ผู้ร้องเรียน</th>
            <th>เบอร์โทรศัพท์</th>
            <th>วันที่</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($complain->result() as $rs): $i++;
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><a href="<?php echo site_url('complain/backend/view/'.$rs->id)?>"><?php echo $rs->head_complain ?></a></td>
                <td><?php echo $rs->name ?></td>
                <td><?php echo $rs->tel ?></td>
                <td><?php echo $this->tak->thaidate($rs->d_update) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript">
    function getdata() {
        var year = $("#year").val();
        var month = $("#month").val();
        var url = "<?php echo site_url('complain/backend/index') ?>" + "/" + year + "/" + month;
        window.location = url;
    }
</script>
